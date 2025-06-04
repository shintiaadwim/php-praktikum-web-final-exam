<?php
    session_start();
    include 'connection/koneksi.php';
    date_default_timezone_set('Asia/Jakarta');

    if (!isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true) {
        header("Location: http://localhost/uas-pweb/login.php");
        exit();
    }

    $sql_matkul = "SELECT * FROM matkul";
    $result_matkul = mysqli_query($conn, $sql_matkul);

    // Mendapatkan matkul yang dipilih dari parameter GET
    $selected_matkul = isset($_GET['matkul']) ? $_GET['matkul'] : '';

    // Query untuk mengambil materi berdasarkan matkul yang dipilih
    $sql_materi = "SELECT * FROM materi";
    if ($selected_matkul) {
        $sql_materi .= " WHERE id = '".mysqli_real_escape_string($conn, $selected_matkul)."'";
    }
    $sql_materi .= " ORDER BY date ASC"; // Mengurutkan berdasarkan tanggal secara ascending
    $result_materi = mysqli_query($conn, $sql_materi);
?>

<?php 
    $pageTitle = "Materi";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>

<div class="sm:ml-64 mt-14">
    <div class="p-4">
        <div class="pb-4 text-2xl font-bold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Materi Kelas 1 D4 Teknik Informatika B
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">This is a list of students in Informatics Engineering Class 1B, including names, student NRP, and other details. Use this list to get to know your classmates better.</p>
        </div>
        
        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer', 'admin'])): ?>
                <div><?php include 'materi-create.php'; ?></div>
            <?php endif; ?>

            <!-- Dropdown matkul : melooping sebuah data matkul dan memproses parameter tsb untuk memfilter matkul yang akan di pilih -->
            <!-- <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['mahasiswa', 'admin'])): ?>
                <form method="get" class="px-4">
                    <select name="matkul" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="">Semua Matakuliah</option>
                        <?php while ($matkul = mysqli_fetch_assoc($result_matkul)): ?>
                            <option value="<?php echo $matkul['id']; ?>" <?php if ($selected_matkul == $matkul['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($matkul['name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </form>
            <?php endif; ?> -->
                
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative ml-auto">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search-users"
                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search for materi">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <?php
                if (mysqli_num_rows($result_materi) > 0) {
                    while ($row_materi = mysqli_fetch_assoc($result_materi)) {
                        $id = $row_materi["id"];
                        $uniqueId = 'dropdown_' . $id;
            ?>
                        <div class="bg-white p-3 border border-gray-200 rounded-lg shadow-sm w-full dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                                <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><?php echo $row_materi["name"]; ?></h5>

                                <button id="dropdownButton_<?php echo $id; ?>" data-dropdown-toggle="<?php echo $uniqueId; ?>" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                                    <span class="sr-only">Open dropdown</span>
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                        <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                    </svg>
                                </button>
                                
                                <div id="<?php echo $uniqueId; ?>" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                                    <ul class="py-2" aria-labelledby="dropdownButton">
                                        <li>
                                            <a href="process/materi-remove.php?id=<?php echo $row_materi["id"]; ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <p class="font-normal text-gray-500 dark:text-gray-400"><?php echo $row_materi["content"]; ?></p>
                            <p class="mb-3 font-normal italic text-gray-500 dark:text-gray-400">Diupload pada tanggal <?php echo date("d M Y, H:i", strtotime($row_materi["date"])); ?></p>
                            <div class="text-center px-5 py-2.5 bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 rounded-lg dark:bg-sky-600">
                                <a href="materi-view.php?id=<?php echo $row_materi['id']; ?>" class="inline-flex font-medium items-center text-white">
                                    See more
                                    <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
            <?php
                    }
                } else {
                    echo "<tr><td colspan='5' class='px-4 py-2 border text-center'>No data found</td></tr>";
                }
            ?>
        </div>
    </div>
    <?php include 'layouts/footer.php'; ?>
</div>