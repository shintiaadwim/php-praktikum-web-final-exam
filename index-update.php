<?php
    session_start();
    include 'connection/koneksi.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql_mhs = "SELECT * FROM mahasiswa WHERE id='$id'";
        $result_mhs = mysqli_query($conn, $sql_mhs);
        
        if ($result_mhs && mysqli_num_rows($result_mhs) > 0) {
            $row_mhs = mysqli_fetch_assoc($result_mhs);
        } else {
            die("Query error: " . mysqli_error($conn));
        }
    }

    mysqli_close($conn);
?>

<?php 
    $pageTitle = "Update Data Mahasiswa";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>
<div class="p-4 sm:ml-64 mt-8 flex items-center justify-center h-screen">
    <div class="relative w-full max-w-md max-h-full border border-gray-200 rounded-lg shadow-sm sm:p-4 md:p-4 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update data student</h3>
        </div>
        <form action="process/edit.php" method="POST" class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <input type="hidden" name="id" value="<?php echo $row_mhs['id']; ?>">

                    <label for="nrp"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NRP</label>
                    <input type="number" name="nrp" id="nrp" value="<?php echo $row_mhs['nrp']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="NRP student" required="">
                </div>
                <div class="col-span-2">
                    <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $row_mhs['name']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Name student" required="">
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="age"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $row_mhs['age']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Age student" required="">
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="gender"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                    <select name="gender" id="gender"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="">
                        <option selected="">Select gender</option>
                        <option value="Male" <?php echo ($row_mhs['gender']=='Male' ) ? 'selected' : '' ; ?>>Male
                        </option>
                        <option value="Female" <?php echo ($row_mhs['gender']=='Female' ) ? 'selected' : '' ; ?>>Female</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label for="address"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                    <textarea name="address" id="address" rows="4" value="<?php echo $row_mhs['address']; ?>" 
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Write address here" required=""></textarea>
                </div>
            </div>
            <button type="submit"
                class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Update
            </button>
        </form>
    </div>
</div>
