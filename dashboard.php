<?php 
    session_start();
    include 'connection/koneksi.php';
    
    if (!isset($_SESSION['user_login'])  || $_SESSION['user_login'] !== true) {
        header("Location: http://localhost/uas-pweb/login.php");
        exit();
    }
?>

<?php     
    $pageTitle = "Dashboard";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>

<?php 
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa");
    $row = mysqli_fetch_assoc($result);
    $totalMahasiswa = $row['total'];
    
    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM lecturer");
    $row = mysqli_fetch_assoc($result);
    $totalProfileDosen = $row['total'];

    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM materi");
    $row = mysqli_fetch_assoc($result);
    $totalMateri = $row['total'];
?>

<div class="sm:ml-64 mt-14">
    <div class="p-4">
        <div class="pb-4 text-2xl font-bold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Dashboard Mahasisawa 1 D4 Teknik Informatika B
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-sky-500 p-6 border border-gray-200 rounded-lg shadow-sm w-full dark:bg-gray-800 dark:border-gray-700">
                <svg class="w-7 h-7 text-white dark:text-white mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M12.4472 2.10557c-.2815-.14076-.6129-.14076-.8944 0L5.90482 4.92956l.37762.11119c.01131.00333.02257.00687.03376.0106L12 6.94594l5.6808-1.89361.3927-.13363-5.6263-2.81313ZM5 10V6.74803l.70053.20628L7 7.38747V10c0 .5523-.44772 1-1 1s-1-.4477-1-1Zm3-1c0-.42413.06601-.83285.18832-1.21643l3.49538 1.16514c.2053.06842.4272.06842.6325 0l3.4955-1.16514C15.934 8.16715 16 8.57587 16 9c0 2.2091-1.7909 4-4 4-2.20914 0-4-1.7909-4-4Z"/>
                    <path d="M14.2996 13.2767c.2332-.2289.5636-.3294.8847-.2692C17.379 13.4191 19 15.4884 19 17.6488v2.1525c0 1.2289-1.0315 2.1428-2.2 2.1428H7.2c-1.16849 0-2.2-.9139-2.2-2.1428v-2.1525c0-2.1409 1.59079-4.1893 3.75163-4.6288.32214-.0655.65589.0315.89274.2595l2.34883 2.2606 2.3064-2.2634Z"/>
                </svg>
                <a href="index.php">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-white dark:text-white">Mahasisawa (<?php echo $totalMahasiswa; ?>)</h5>
                </a>
                <p class="mb-3 font-normal text-white dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
                <div class="text-center px-5 py-2.5 bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 rounded-lg dark:bg-sky-600">
                    <a href="index.php" class="inline-flex font-medium items-center text-white hover:underline">
                        See more
                        <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-green-500 p-6 border border-gray-200 rounded-lg shadow-sm w-full dark:bg-gray-800 dark:border-gray-700">
                <svg class="w-7 h-7 text-white dark:text-white mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6 2c-1.10457 0-2 .89543-2 2v4c0 .55228.44772 1 1 1s1-.44772 1-1V4h12v7h-2c-.5523 0-1 .4477-1 1v2h-1c-.5523 0-1 .4477-1 1s.4477 1 1 1h5c.5523 0 1-.4477 1-1V3.85714C20 2.98529 19.3667 2 18.268 2H6Z"/>
                    <path d="M6 11.5C6 9.567 7.567 8 9.5 8S13 9.567 13 11.5 11.433 15 9.5 15 6 13.433 6 11.5ZM4 20c0-2.2091 1.79086-4 4-4h3c2.2091 0 4 1.7909 4 4 0 1.1046-.8954 2-2 2H6c-1.10457 0-2-.8954-2-2Z"/>
                </svg>
                <a href="lecturer.php">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-white dark:text-white">Profile Dosen (<?php echo $totalProfileDosen; ?>)</h5>
                </a>
                <p class="mb-3 font-normal text-white dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
                <div class="text-center px-5 py-2.5 bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg dark:bg-green-600">
                    <a href="lecturer.php" class="inline-flex font-medium items-center text-white hover:underline">
                        See more
                        <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-yellow-500 p-6 border border-gray-200 rounded-lg shadow-sm w-full dark:bg-gray-800 dark:border-gray-700">
                <svg class="w-7 h-7 text-white dark:text-white mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z" clip-rule="evenodd"/>
                </svg>
                <a href="materi.php">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-white dark:text-white">Materi (<?php echo $totalMateri; ?>)</h5>
                </a>
                <p class="mb-3 font-normal text-white dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
                <div class="text-center px-5 py-2.5 bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 rounded-lg dark:bg-yellow-600">
                    <a href="materi.php" class="inline-flex font-medium items-center text-white hover:underline">
                        See more
                        <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-red-500 p-6 border border-gray-200 rounded-lg shadow-sm w-full dark:bg-gray-800 dark:border-gray-700">
                <svg class="w-7 h-7 text-white dark:text-white mb-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M18 14a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2Z" clip-rule="evenodd"/> 
                    <path fill-rule="evenodd" d="M15.026 21.534A9.994 9.994 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2c2.51 0 4.802.924 6.558 2.45l-7.635 7.636L7.707 8.87a1 1 0 0 0-1.414 1.414l3.923 3.923a1 1 0 0 0 1.414 0l8.3-8.3A9.956 9.956 0 0 1 22 12a9.994 9.994 0 0 1-.466 3.026A2.49 2.49 0 0 0 20 14.5h-.5V14a2.5 2.5 0 0 0-5 0v.5H14a2.5 2.5 0 0 0 0 5h.5v.5c0 .578.196 1.11.526 1.534Z" clip-rule="evenodd"/>
                </svg>
                <a href="nilai.php">
                    <h5 class="mb-2 text-2xl font-semibold tracking-tight text-white dark:text-white">Nilai</h5>
                </a>
                <p class="mb-3 font-normal text-white dark:text-gray-400">Go to this step by step guideline process on how to certify for your weekly benefits:</p>
                <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['admin'])): ?>
                    <div class="text-center px-5 py-2.5 bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg dark:bg-red-600">
                        <a href="nilai.php" class="inline-flex font-medium items-center text-white hover:underline">
                            See more
                            <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778"/>
                            </svg>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include 'layouts/footer.php'; ?>
</div>