<?php
    session_start();
    include 'connection/koneksi.php';
    date_default_timezone_set('Asia/Jakarta');

    $id = isset($_GET['id']) ? intval($_GET['id']) : 0; 

    // === QUERY TUGAS ===
    $sql_tugas = "SELECT tugas.*, matkul.name AS matkul_name FROM tugas 
                LEFT JOIN matkul ON tugas.matkul_id = matkul.id 
                WHERE tugas.id = $id";
    $result_tugas = mysqli_query($conn, $sql_tugas);

    // === QUERY SUBMISSION ===
    $result_submit = null;
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'mahasiswa') {
        $user_id = $_SESSION['user_id'];
        $result_submit = mysqli_query($conn, "SELECT * FROM submissions WHERE tugas_id = $id AND mahasiswa_id = $user_id");
    } elseif (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer', 'admin'])) {
        $result_submit = mysqli_query($conn, "SELECT submissions.*, mahasiswa.nrp, mahasiswa.name FROM submissions LEFT JOIN mahasiswa ON submissions.mahasiswa_id = mahasiswa.id WHERE tugas_id = $id");
    }

    // === QUERY MAHASISWA SAAT UPLOAD TUGAS ===
    $sql_mhs = "SELECT * FROM mahasiswa ORDER BY nrp";
    $result_mhs = mysqli_query($conn, $sql_mhs);

    // === QUERY GENDER ===
    $male = 0;
    $female = 0;

    $sql_gender = "SELECT gender, COUNT(*) AS total FROM mahasiswa GROUP BY gender";
    $result_gender = mysqli_query($conn, $sql_gender);

    if ($result_gender) {
        while ($row_gender = mysqli_fetch_assoc($result_gender)) {
            $gender = strtolower(trim($row_gender['gender'])); // normalisasi: huruf kecil + hapus spasi
            if ($gender === 'male' || $gender === 'laki-laki' || $gender === 'm') {
                $male = $row_gender['total'];
            } elseif ($gender === 'female' || $gender === 'perempuan' || $gender === 'f') {
                $female = $row_gender['total'];
            }
        }
    }

    $total = $male + $female;
    
    // === QUERY FILES ===
    $folder = "files/tugas/";
    $file = null;

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = mysqli_query($conn, "SELECT path FROM tugas WHERE id = $id");
        if ($data = mysqli_fetch_assoc($query)) {
            $file = $data['path'];
        }
    }

    if (!$file) {
        $availableFiles = array_values(array_diff(scandir($folder), array('.', '..')));
        $defaultFile = count($availableFiles) > 0 ? $availableFiles[0] : null;
        $file = isset($_GET['file']) && $_GET['file'] !== '' ? $_GET['file'] : $defaultFile;
    }

    $file = basename($file);
    $filePath = $folder . $file;
?>

<?php 
    $pageTitle = "Tugas Preview";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>

<div class="sm:ml-64 mt-14">
    <div class="p-4">
        <div class="pb-4 text-2xl font-bold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">Detail Tugas</div>

        <?php
            if (mysqli_num_rows($result_tugas) > 0) {
                while ($row_tugas = mysqli_fetch_assoc($result_tugas)) {
                    $fileType = $row_tugas["type"]; // Mendapatkan tipe file dari database
                    $ext = match ($fileType) {
                        "application/pdf" => "PDF",
                        "application/pptx" => "PPTX",
                        "application/vnd.openxmlformats-officedocument.wordprocessingml.document" => "DOCX",
                        "application/msword" => "DOC",
                        "image/png" => "PNG",
                        "image/jpeg" => "JPG",
                        default => strtoupper(pathinfo($row_tugas["path"], PATHINFO_EXTENSION)) // Jika tipe file tidak dikenali, gunakan ekstensi dari path
                    };

                    $sizeKB = $row_tugas["size"];       // Mengambil ukuran file dari database dalam bentuk KB
                    $sizeMB = round($sizeKB / 1024, 2); // Lalu dikonversi ke MB dan dibulatkan 2 angka di belakang koma
        ?>
                    <!-- role mahasiswa -->
                    <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['mahasiswa'])): ?>
                        <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                            <div class="py-4 w-full md:w-2/3">
                                <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Assignment Title</h5>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400"><?php echo $row_tugas["name"]; ?></p>

                                <p class="font-bold text-gray-700 dark:text-gray-400">Description :</p>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400"><?php echo $row_tugas["content"]; ?></p>

                                <p class="font-bold text-gray-700 dark:text-gray-400">Deadline :</p>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400"><?php echo date("d M Y, H:i", strtotime($row_tugas["date"])); ?></p>

                                <p class="font-bold text-gray-700 dark:text-gray-400">Subject :</p>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400">
                                    <?php 
                                        if(!empty($row_tugas["matkul_name"])) { // Cel apakah data data matkul
                                            echo $row_tugas["matkul_name"]; // Jika ada data matkul di sertakan
                                        } else {
                                            echo "No subject assigned";     // Jika data matkul tidak di sertakan
                                        }
                                    ?>
                                </p>

                                <p class="font-bold text-gray-700 dark:text-gray-400">Attachment :</p>
                                <?php if (!empty($row_tugas['path'])): ?>
                                    <div class="w-full md:w-2/5 flex items-center mb-4 p-3 border border-gray-200 rounded-lg shadow-sm">
                                        <div class="w-5/6">
                                            <span class="flex items-center gap-2 text-sm font-bold text-gray-900 dark:text-white pb-2">
                                                <svg fill="none" aria-hidden="true" class="w-5 h-5 shrink-0" viewBox="0 0 20 21">
                                                    <g clip-path="url(#clip0_3173_1381)">
                                                        <path fill="#E2E5E7" d="M5.024.5c-.688 0-1.25.563-1.25 1.25v17.5c0 .688.562 1.25 1.25 1.25h12.5c.687 0 1.25-.563 1.25-1.25V5.5l-5-5h-8.75z"/>
                                                        <path fill="#B0B7BD" d="M15.024 5.5h3.75l-5-5v3.75c0 .688.562 1.25 1.25 1.25z"/>
                                                        <path fill="#CAD1D8" d="M18.774 9.25l-3.75-3.75h3.75v3.75z"/>
                                                        <path fill="#F15642" d="M16.274 16.75a.627.627 0 01-.625.625H1.899a.627.627 0 01-.625-.625V10.5c0-.344.281-.625.625-.625h13.75c.344 0 .625.281.625.625v6.25z"/>
                                                        <path fill="#fff" d="M3.998 12.342c0-.165.13-.345.34-.345h1.154c.65 0 1.235.435 1.235 1.269 0 .79-.585 1.23-1.235 1.23h-.834v.66c0 .22-.14.344-.32.344a.337.337 0 01-.34-.344v-2.814zm.66.284v1.245h.834c.335 0 .6-.295.6-.605 0-.35-.265-.64-.6-.64h-.834zM7.706 15.5c-.165 0-.345-.09-.345-.31v-2.838c0-.18.18-.31.345-.31H8.85c2.284 0 2.234 3.458.045 3.458h-1.19zm.315-2.848v2.239h.83c1.349 0 1.409-2.24 0-2.24h-.83zM11.894 13.486h1.274c.18 0 .36.18.36.355 0 .165-.18.3-.36.3h-1.274v1.049c0 .175-.124.31-.3.31-.22 0-.354-.135-.354-.31v-2.839c0-.18.135-.31.355-.31h1.754c.22 0 .35.13.35.31 0 .16-.13.34-.35.34h-1.455v.795z"/>
                                                        <path fill="#CAD1D8" d="M15.649 17.375H3.774V18h11.875a.627.627 0 00.625-.625v-.625a.627.627 0 01-.625.625z"/>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_3173_1381">
                                                        <path fill="#fff" d="M0 0h20v20H0z" transform="translate(0 .5)"/>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                <?php echo pathinfo($row_tugas["path"], PATHINFO_FILENAME); ?> 
                                            </span>

                                            <span class="flex text-xs font-normal text-gray-500 dark:text-gray-400 gap-2">
                                                <?php echo round($row_tugas["size"] / 1024, 2); ?> MB
                                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="self-center" width="4" height="4" viewBox="0 0 4 4" fill="none">
                                                    <circle cx="2" cy="2" r="2" fill="#6B7280"/>
                                                </svg>
                                                <?php echo strtoupper(pathinfo($row_tugas["path"], PATHINFO_EXTENSION)); ?>
                                            </span>
                                        </div>

                                        <div class="flex justify-end w-1/6">
                                            <button type="button" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                                <svg class="w-5 h-5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                                    <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="mb-2 font-normal italic text-gray-700 dark:text-gray-400">No attachments</p>
                                <?php endif; ?>
                            </div>

                            <?php
                                $submission = [];
                                if (mysqli_num_rows($result_submit) > 0) {
                                    $submission = mysqli_fetch_assoc($result_submit);
                                }
                            ?>
                            <div class="p-3 border border-gray-200 rounded-lg shadow-sm py-4 w-full md:w-1/3">
                                <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 mb-2">
                                    <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Your Work</h5>
                                    <p class="font-normal text-gray-700 dark:text-gray-400">
                                        <?php
                                            // Cek apakah pengumpulan tugas sudah ada
                                            if (!empty($submission)) { 
                                                $deadline = strtotime($row_tugas["date"]); 
                                                $submit_time = strtotime($submission["date"]);

                                                // Cek apakah nilai sudah diberikan oleh dosen
                                                if (isset($submission["nilai"]) && $submission["nilai"] !== "" && $submission["nilai"] !== "0") {
                                                    echo "<span class='text-green-600 font-semibold italic'>telah dinilai</span>";
                                                } else if ($submit_time > $deadline) {
                                                    echo "<span class='text-pink-600 font-semibold italic'>terlambat mengumpulkan</span>";
                                                } else {
                                                    echo "<span class='text-yellow-600 font-semibold italic'>terkumpul</span>";
                                                }
                                            } else {
                                                echo "<span class='text-red-600 font-semibold italic'>belum terkumpul</span>";
                                            }
                                        ?>
                                    </p>
                                </div>
                                <?php if (!empty($submission)): ?>
                                    <p class="font-bold text-gray-700 dark:text-gray-400">Collect :</p>
                                    <p class="mb-2 font-normal text-gray-700 dark:text-gray-400">
                                        <?php echo date("d M Y, H:i", strtotime($submission["date"])); ?>
                                    </p>

                                    <p class="font-bold text-gray-700 dark:text-gray-400">Note :</p>
                                    <p class="mb-2 font-normal text-gray-700 dark:text-gray-400">
                                        <?php echo $submission["content"]; ?>
                                    </p>

                                    <p class="font-bold text-gray-700 dark:text-gray-400">Nilai :</p>
                                    <p class="mb-2 font-normal text-gray-700 dark:text-gray-400">
                                        <?php 
                                            if (!empty($submission["nilai"]) || $submission["nilai"] === "0") {
                                                echo $submission["nilai"];
                                            } else {
                                                echo "<span class='italic text-gray-400'>Belum dinilai</span>";
                                            }
                                        ?>
                                    </p>

                                    <p class="font-bold text-gray-700 dark:text-gray-400">Attachment :</p> 
                                        <div class="flex items-center mb-4 p-3 border border-gray-200 rounded-lg shadow-sm">
                                            <div class="w-5/6">
                                                <span class="flex items-center gap-2 text-sm font-bold text-gray-900 dark:text-white pb-2">
                                                    <svg fill="none" aria-hidden="true" class="w-5 h-5 shrink-0" viewBox="0 0 20 21">
                                                        <g clip-path="url(#clip0_3173_1381)">
                                                            <path fill="#E2E5E7" d="M5.024.5c-.688 0-1.25.563-1.25 1.25v17.5c0 .688.562 1.25 1.25 1.25h12.5c.687 0 1.25-.563 1.25-1.25V5.5l-5-5h-8.75z"/>
                                                            <path fill="#B0B7BD" d="M15.024 5.5h3.75l-5-5v3.75c0 .688.562 1.25 1.25 1.25z"/>
                                                            <path fill="#CAD1D8" d="M18.774 9.25l-3.75-3.75h3.75v3.75z"/>
                                                            <path fill="#F15642" d="M16.274 16.75a.627.627 0 01-.625.625H1.899a.627.627 0 01-.625-.625V10.5c0-.344.281-.625.625-.625h13.75c.344 0 .625.281.625.625v6.25z"/>
                                                            <path fill="#fff" d="M3.998 12.342c0-.165.13-.345.34-.345h1.154c.65 0 1.235.435 1.235 1.269 0 .79-.585 1.23-1.235 1.23h-.834v.66c0 .22-.14.344-.32.344a.337.337 0 01-.34-.344v-2.814zm.66.284v1.245h.834c.335 0 .6-.295.6-.605 0-.35-.265-.64-.6-.64h-.834zM7.706 15.5c-.165 0-.345-.09-.345-.31v-2.838c0-.18.18-.31.345-.31H8.85c2.284 0 2.234 3.458.045 3.458h-1.19zm.315-2.848v2.239h.83c1.349 0 1.409-2.24 0-2.24h-.83zM11.894 13.486h1.274c.18 0 .36.18.36.355 0 .165-.18.3-.36.3h-1.274v1.049c0 .175-.124.31-.3.31-.22 0-.354-.135-.354-.31v-2.839c0-.18.135-.31.355-.31h1.754c.22 0 .35.13.35.31 0 .16-.13.34-.35.34h-1.455v.795z"/>
                                                            <path fill="#CAD1D8" d="M15.649 17.375H3.774V18h11.875a.627.627 0 00.625-.625v-.625a.627.627 0 01-.625.625z"/>
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_3173_1381">
                                                            <path fill="#fff" d="M0 0h20v20H0z" transform="translate(0 .5)"/>
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                    <?php echo pathinfo($submission["path"], PATHINFO_FILENAME); ?>
                                                </span>

                                                <span class="flex text-xs font-normal text-gray-500 dark:text-gray-400 gap-2">
                                                    <!-- 12 Pages 
                                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="self-center" width="4" height="4" viewBox="0 0 4 4" fill="none">
                                                        <circle cx="2" cy="2" r="2" fill="#6B7280"/>
                                                    </svg> -->
                                                    <?php echo round($submission["size"] / 1024, 2); ?> MB
                                                    <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="self-center" width="4" height="4" viewBox="0 0 4 4" fill="none">
                                                        <circle cx="2" cy="2" r="2" fill="#6B7280"/>
                                                    </svg>
                                                    <?php echo strtoupper(pathinfo($submission["path"], PATHINFO_EXTENSION)); ?>
                                                </span>
                                            </div>

                                            <div class="flex justify-end w-1/6">
                                                <button type="button" class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                                    <svg class="w-5 h-5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                                        <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                <?php else: ?>
                                    <p class="mb-2 font-normal italic text-gray-700 dark:text-gray-400">No submissions yet.</p>
                                <?php endif; ?>

                                <?php
                                    $tugas_id = $row_tugas['id'];
                                    $matkul_id = $row_tugas['matkul_id'];
                                ?>
                                <div><?php include 'tugas-submission.php'; ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- role dosen -->
                    <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer', 'admin'])): ?>
                        <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                            <div class="py-4 w-full md:w-2/3">
                                <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Assignment Title</h5>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400"><?php echo $row_tugas["name"]; ?></p>

                                <p class="font-bold text-gray-700 dark:text-gray-400">Description :</p>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400"><?php echo $row_tugas["content"]; ?></p>

                                <p class="font-bold text-gray-700 dark:text-gray-400">Subject :</p>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400">
                                    <?php 
                                        if(!empty($row_tugas["matkul_name"])) {
                                            echo $row_tugas["matkul_name"];
                                        } else {
                                            echo "No subject assigned";
                                        }
                                    ?>
                                </p>

                                <p class="font-bold text-gray-700 dark:text-gray-400">Deadline :</p>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400"><?php echo date("d M Y, H:i", strtotime($row_tugas["date"])); ?></p>
                                
                                <p class="font-bold text-gray-700 dark:text-gray-400">Attachment :</p>
                                <?php if (!empty($row_tugas['path'])): ?>
                                    <div class="w-full md:w-2/5 flex items-center mb-4 p-3 border border-gray-200 rounded-lg shadow-sm">
                                        <div class="w-5/6">
                                            <span class="flex items-center gap-2 text-sm font-bold text-gray-900 dark:text-white pb-2">
                                                <svg fill="none" aria-hidden="true" class="w-5 h-5 shrink-0" viewBox="0 0 20 21">
                                                    <g clip-path="url(#clip0_3173_1381)">
                                                        <path fill="#E2E5E7" d="M5.024.5c-.688 0-1.25.563-1.25 1.25v17.5c0 .688.562 1.25 1.25 1.25h12.5c.687 0 1.25-.563 1.25-1.25V5.5l-5-5h-8.75z"/>
                                                        <path fill="#B0B7BD" d="M15.024 5.5h3.75l-5-5v3.75c0 .688.562 1.25 1.25 1.25z"/>
                                                        <path fill="#CAD1D8" d="M18.774 9.25l-3.75-3.75h3.75v3.75z"/>
                                                        <path fill="#F15642" d="M16.274 16.75a.627.627 0 01-.625.625H1.899a.627.627 0 01-.625-.625V10.5c0-.344.281-.625.625-.625h13.75c.344 0 .625.281.625.625v6.25z"/>
                                                        <path fill="#fff" d="M3.998 12.342c0-.165.13-.345.34-.345h1.154c.65 0 1.235.435 1.235 1.269 0 .79-.585 1.23-1.235 1.23h-.834v.66c0 .22-.14.344-.32.344a.337.337 0 01-.34-.344v-2.814zm.66.284v1.245h.834c.335 0 .6-.295.6-.605 0-.35-.265-.64-.6-.64h-.834zM7.706 15.5c-.165 0-.345-.09-.345-.31v-2.838c0-.18.18-.31.345-.31H8.85c2.284 0 2.234 3.458.045 3.458h-1.19zm.315-2.848v2.239h.83c1.349 0 1.409-2.24 0-2.24h-.83zM11.894 13.486h1.274c.18 0 .36.18.36.355 0 .165-.18.3-.36.3h-1.274v1.049c0 .175-.124.31-.3.31-.22 0-.354-.135-.354-.31v-2.839c0-.18.135-.31.355-.31h1.754c.22 0 .35.13.35.31 0 .16-.13.34-.35.34h-1.455v.795z"/>
                                                        <path fill="#CAD1D8" d="M15.649 17.375H3.774V18h11.875a.627.627 0 00.625-.625v-.625a.627.627 0 01-.625.625z"/>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_3173_1381">
                                                        <path fill="#fff" d="M0 0h20v20H0z" transform="translate(0 .5)"/>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                <?php echo pathinfo($row_tugas["path"], PATHINFO_FILENAME); ?>
                                            </span>
                
                                            <span class="flex text-xs font-normal text-gray-500 dark:text-gray-400 gap-2">
                                                <!-- 12 Pages 
                                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="self-center" width="4" height="4" viewBox="0 0 4 4" fill="none">
                                                    <circle cx="2" cy="2" r="2" fill="#6B7280"/>
                                                </svg> -->
                                                <?php echo round($row_tugas["size"] / 1024, 2); ?> MB
                                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="self-center" width="4" height="4" viewBox="0 0 4 4" fill="none">
                                                    <circle cx="2" cy="2" r="2" fill="#6B7280"/>
                                                </svg>
                                                <?php echo strtoupper(pathinfo($row_tugas["path"], PATHINFO_EXTENSION)); ?>
                                            </span>
                                        </div>
                
                                        <div class="flex justify-end w-1/6">
                                            <a href="<?php echo $submission['path']; ?>" download class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:focus:ring-gray-600">
                                                <svg class="w-5 h-5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                                                    <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="mb-2 font-normal italic text-gray-700 dark:text-gray-400">No attachments</p>
                                <?php endif; ?>
                            </div>
                        
                            <div class="p-3 border border-gray-200 rounded-lg shadow-sm py-4 h-56 w-full md:w-1/3">
                                <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Total Student</h5>
                                <p class="font-bold text-gray-700 dark:text-gray-400">Male : </p>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400">Berjumlah <?php echo $male; ?> orang</p>

                                <p class="font-bold text-gray-700 dark:text-gray-400">Female : </p>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400">Berjumlah <?php echo $female; ?> orang</p>
                                
                                <p class="font-bold text-gray-700 dark:text-gray-400">Total keseluruhan : </p>
                                <p class="mb-2 font-normal text-gray-700 dark:text-gray-400">Berjumlah <?php echo $total; ?> orang</p>
                            </div>
                        </div>

                        <div class="mt-4 relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <!-- <th scope="col" class="px-6 py-3">ID</th> -->
                                        <th scope="col" class="px-6 py-3">NRP</th>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">File</th>
                                        <th scope="col" class="px-6 py-3">Nilai</th>
                                        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer'])): ?>
                                            <th scope="col" class="px-6 py-3">Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if (isset($result_submit) && mysqli_num_rows($result_submit) > 0) {
                                        while ($row_submit = mysqli_fetch_assoc($result_submit)) {
                                ?>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <!-- <td class="px-6 py-4 font-medium text-gray-900 dark:text-white"><?php echo $row_submit["id"]; ?></td> -->
                                        <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_submit["nrp"]; ?></td>
                                        <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_submit["name"]; ?></td>
                                        <td class="px-6 py-4 font-medium text-gray-500 dark:text-white">
                                            <a href="tugas-submission-view.php?id=<?php echo $row_submit['id']; ?>" class="flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">
                                                <span>Lihat tugas</span>
                                                <svg class="w-6 h-6 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_submit["nilai"]; ?></td>
                                        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer'])): ?>
                                            <td class="flex items-center px-6 py-4">
                                                <a href="tugas-submission-update.php?id=<?php echo $row_submit["id"]; ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Add Nilai</a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='px-4 py-2 border text-center'>No data found</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

        <?php
                }
            } else {
                echo "<tr><td colspan='5' class='px-4 py-2 border text-center'>No data found</td></tr>";
            }
        ?>

        <?php include 'layouts/footer.php'; ?>
    </div>
</div>