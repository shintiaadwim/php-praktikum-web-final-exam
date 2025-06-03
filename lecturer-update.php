<?php
    session_start();
    include 'connection/koneksi.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql_lecturer = "SELECT * FROM lecturer WHERE id='$id'";
        $result_lecturer = mysqli_query($conn, $sql_lecturer);
        
        if ($result_lecturer && mysqli_num_rows($result_lecturer) > 0) {
            $row_lecturer = mysqli_fetch_assoc($result_lecturer);
        } else {
            die("Query error: " . mysqli_error($conn));
        }
    }

    mysqli_close($conn);
?>

<?php 
    $pageTitle = "Update Data Lecturer";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>

<div class="p-4 sm:ml-64 mt-8 flex items-center justify-center h-screen">
    <div class="relative w-full max-w-md max-h-full border border-gray-200 rounded-lg shadow-sm sm:p-4 md:p-4 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update data lecturer</h3>
        </div>
        <form action="process/lecturer-edit.php" method="POST" class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <input type="hidden" name="id" value="<?php echo $row_lecturer['id']; ?>">

                    <label for="nip"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                    <input type="number" name="nip" id="nip" value="<?php echo $row_lecturer['nip']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="NIP lecturer" required="">
                </div>
                <div class="col-span-2">
                    <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $row_lecturer['name']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Name lecturer" required="">
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="matakuliah"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata Kuliah</label>
                    <select name="matakuliah" id="matakuliah"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="">
                        <option selected="">Select Matkul</option>
                        <option value="Prak. Alogoritma & Struktur Data" <?php echo ($row_lecturer['matakuliah']=='psad' ) ? 'selected' : '' ; ?>>Prak. Alogoritma & Struktur Data</option>
                        <option value="Alogoritma & Struktur Data"<?php echo ($row_lecturer['matakuliah']=='asd' ) ? 'selected' : '' ; ?>>Algoritma & Struktur Data</option>
                        <option value="Basis Data" <?php echo ($row_lecturer['matakuliah']=='bd' ) ? 'selected' : '' ; ?>>Basis Data</option>
                        <option value="Sistem Operasi" <?php echo ($row_lecturer['matakuliah']=='os' ) ? 'selected' : '' ; ?>>Sistem Operasi</option>
                        <option value="Prak. Basis Data" <?php echo ($row_lecturer['matakuliah']=='pbd' ) ? 'selected' : '' ; ?>>Prak. Basis Data</option>
                        <option value="Prak. Pemrograman Web" <?php echo ($row_lecturer['matakuliah']=='ppweb' ) ? 'selected' : '' ; ?>>Prak. Pemrograman Web</option>
                        <option value="Pemrograman Web" <?php echo ($row_lecturer['matakuliah']=='pweb' ) ? 'selected' : '' ; ?>>Pemrograman Web</option>
                        <option value="Kewarganegaraan" <?php echo ($row_lecturer['matakuliah']=='kwn' ) ? 'selected' : '' ; ?>>Kewarganegaraan</option>
                        <option value="Prak. Sistem Operasi" <?php echo ($row_lecturer['matakuliah']=='pos' ) ? 'selected' : '' ; ?>>Prak. Sistem Operasi</option>
                        <option value="Matematika 2" <?php echo ($row_lecturer['matakuliah']=='mtk' ) ? 'selected' : '' ; ?>>Matematika 2</option>
                    </select>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="room"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Room</label>
                    <select name="room" id="room"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="">
                        <option selected="">Select Room</option>
                        <option value="A 301" <?php echo ($row_lecturer['room']=='A 301' ) ? 'selected' : '' ; ?> >A 301</option>
                        <option value="B 205" <?php echo ($row_lecturer['room']=='B 205' ) ? 'selected' : '' ; ?> >B 205</option>
                        <option value="C 105" <?php echo ($row_lecturer['room']=='C 105' ) ? 'selected' : '' ; ?> >C 105</option>
                        <option value="C 106" <?php echo ($row_lecturer['room']=='C 106' ) ? 'selected' : '' ; ?> >C 106</option>
                        <option value="C 206" <?php echo ($row_lecturer['room']=='C 206' ) ? 'selected' : '' ; ?> >C 206</option>
                        <option value="C 307" <?php echo ($row_lecturer['room']=='C 307' ) ? 'selected' : '' ; ?> >C 307</option>
                        <option value="SAW-01.05" <?php echo ($row_lecturer['room']=='SAW-01.05' ) ? 'selected' : '' ; ?> >SAW-01.05</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label for="telp"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telpon</label>
                    <input type="number" name="telp" id="telp" value="<?php echo $row_lecturer['telp']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Telpon lecturer" required="">
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
