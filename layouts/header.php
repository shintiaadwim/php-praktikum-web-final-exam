<?php
    // session_start();
    include "connection/koneksi.php";

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'");
        $row = mysqli_fetch_assoc($query);
    } else {
        header("Location: http://localhost/uas-pweb/login.php");
        exit;
    }
?>

<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="https://flowbite.com" class="flex ms-2 md:me-24">
                    <img src="img/Logo_PENS.png" class="h-8 me-3" alt="Logo PENS" />
                    <span class="self-center text-xl font-bold sm:text-2xl whitespace-nowrap dark:text-white">E-LEARN</span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer'])): ?>
                                <img class="w-8 h-8 rounded-full" src="img/lecturer.jpeg" alt="user photo lecturer">
                            <?php elseif (isset($_SESSION['role']) && in_array($_SESSION['role'], ['mahasiswa'])): ?>
                                <img class="w-8 h-8 rounded-full" src="img/mahasiswa.jpeg" alt="user photo student">
                            <?php else: ?>
                                <img class="w-8 h-8 rounded-full" src="img/admin.jpeg" alt="user photo">
                            <?php endif; ?>
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="role">
                            <p class="text-sm text-gray-900 dark:text-white" role="username"><?php echo $row["username"]; ?></p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="role"><?php echo $row["role"]; ?></p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="profile.php"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">User Profile</a>
                            </li>
                            <li>
                                <a href="process/out.php"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>