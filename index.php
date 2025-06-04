<?php
    session_start();
    include 'connection/koneksi.php';

    if (!isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true) {
        header("Location: http://localhost/uas-pweb/login.php");
        exit();
    }

    // PAGINATION : UNTUK MENGATUR SLIDE DATA MAHASISWA
    $limit = 6; // jumlah data per halaman
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // mengecek apakah ada parameter page di URL (contoh: ?page=2)
    $start = ($page - 1) * $limit; // menghitung data keberapa yang harus mulai ditampilkan

    // Hitung total data mahasiswa yang dibutuhkan untuk pagination
    $result_count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM mahasiswa"); 
    $row_count = mysqli_fetch_assoc($result_count);
    $total_data = $row_count['total'];
    $total_pages = ceil($total_data / $limit);

    // Mengambil data sesuai halaman dan urut sesuai nrp
    $sql_mhs = "SELECT * FROM mahasiswa ORDER BY nrp LIMIT $start, $limit";
    $result_mhs = mysqli_query($conn, $sql_mhs);
?>

<?php 
    $pageTitle = "Input Data";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>

<div class="sm:ml-64 mt-14">
    <div class="p-4">
        <div class="pb-4 text-2xl font-bold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Daftar Data Mahasisawa 1 D4 Teknik Informatika B
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">This is a list of students in Informatics Engineering Class 1B, including names, student NRP, and other details. Use this list to get to know your classmates better.</p>
        </div>

        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer', 'admin'])): ?>
                <div><?php include 'index-create.php'; ?></div>
            <?php endif; ?>
                
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative ml-auto">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search-mahasiswa"
                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-60 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search for mahasiswa" />
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">NRP</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Age</th>
                        <th scope="col" class="px-6 py-3">Gender</th>
                        <th scope="col" class="px-6 py-3">Address</th>
                        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin'])): ?>
                            <th scope="col" class="px-6 py-3">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if (mysqli_num_rows($result_mhs)>0) {
                        while ($row_mhs = mysqli_fetch_assoc($result_mhs)) {
                            $id = $row_mhs["id"];
                ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_mhs["nrp"]; ?></td>
                                <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_mhs["name"]; ?></td>
                                <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_mhs["age"]; ?></td>
                                <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_mhs["gender"]; ?></td>
                                <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_mhs["address"]; ?></td>
                                <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer', 'admin'])): ?>    
                                    <td class="flex items-center px-6 py-4">
                                        <a href="index-update.php?id=<?php echo $row_mhs["id"]; ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Update</a>
                                        <a href="process/remove.php?id=<?php echo $row_mhs["id"]; ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</a>
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
        
        <nav aria-label="Page navigation example" class="mt-4 flex justify-end">
            <ul class="inline-flex -space-x-px text-sm">
                <li>
                    <a href="?page=<?php echo max(1, $page-1); ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                </li>
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <li>
                        <a href="?page=<?php echo $i; ?>" class="flex items-center justify-center px-3 h-8 leading-tight <?php echo $i == $page ? 'text-blue-600 border bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'; ?>">
                        <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
                <li>
                    <a href="?page=<?php echo min($total_pages, $page+1); ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <?php include 'layouts/footer.php'; ?>
</div>