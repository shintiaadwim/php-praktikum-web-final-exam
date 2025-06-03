<?php
    session_start();
    include 'connection/koneksi.php';

    if (!isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true) {
        header("Location: http://localhost/uas-pweb/login.php");
        exit();
    }

    $sql_lecturer = "SELECT * FROM lecturer ORDER BY nip";
    $result_lecturer = mysqli_query($conn, $sql_lecturer);
?>

<?php 
    $pageTitle = "Profile Lecturer";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>

<div class="sm:ml-64 mt-14">
    <div class="p-4">
        <div class="pb-4 text-2xl font-bold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Profile Dosen
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">This is a list of lecturers in Informatics Engineering Class 1B, including names, NIP, and other details. Use this list to get to know your lecturers better.</p>
        </div>

        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin'])): ?>
                <div><?php include 'lecturer-create.php'; ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin'])): ?>
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
                        placeholder="Search for lecturers">
                </div>
            <?php endif; ?>
        </div>

        <!-- Lecturer data table -->
        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin'])): ?>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <!-- <th scope="col" class="px-6 py-3">ID</th> -->
                            <th scope="col" class="px-6 py-3">NIP</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Mata Kuliah</th>
                            <th scope="col" class="px-6 py-3">Room Class</th>
                            <th scope="col" class="px-6 py-3">Telpon</th>
                            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin'])): ?>
                                <th scope="col" class="px-6 py-3">Action</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (mysqli_num_rows($result_lecturer)>0) {
                        while ($row_lecturer = mysqli_fetch_assoc($result_lecturer)) {
                            $id = $row_lecturer["id"];
                    ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <!-- <td class="px-6 py-4 font-medium text-gray-900 dark:text-white"><?php echo $row_lecturer["id"]; ?></td> -->
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_lecturer["nip"]; ?></td>
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_lecturer["name"]; ?></td>
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_lecturer["matakuliah"]; ?></td>
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_lecturer["room"]; ?></td>
                            <td class="px-6 py-4 font-medium text-gray-500 dark:text-white"><?php echo $row_lecturer["telp"]; ?></td>
                            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin'])): ?>
                                <td class="flex items-center px-6 py-4">
                                    <a href="lecturer-update.php?id=<?php echo $row_lecturer["id"]; ?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Update</a>
                                    <a href="process/lecturer-remove.php?id=<?php echo $row_lecturer["id"]; ?>" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</a>
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

        <!-- Profile Dosen -->
        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer'])): ?>
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-end px-4 pt-4">
                    <br>
                </div>

                <?php
                    $nip = $_SESSION['nip'];
                    $sql_profile = "SELECT * FROM lecturer WHERE nip = '$nip' LIMIT 1";
                    $result_profile = mysqli_query($conn, $sql_profile);

                    if ($row_lecturer = mysqli_fetch_assoc($result_profile)) {
                ?>
                    <div class="flex flex-col items-center pb-10">
                        <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="img/lecturer.jpeg" alt="Lecturer"/>
                        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?php echo $row_lecturer["name"]; ?></h5>
                        <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo $row_lecturer["nip"]; ?> - <?php echo $row_lecturer["matakuliah"]; ?></span>
                    </div>
                <?php
                    } else {
                        echo "<div class='px-4 py-2 text-center'>No profile found</div>";
                    }
                ?>
            </div>
        <?php endif; ?>

    </div>
    <?php include 'layouts/footer.php'; ?>
</div>