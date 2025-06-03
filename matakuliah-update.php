<?php
    session_start();
    include 'connection/koneksi.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql_matkul = "SELECT * FROM matkul WHERE id='$id'";
        $result_matkul = mysqli_query($conn, $sql_matkul);
        
        if ($result_matkul && mysqli_num_rows($result_matkul) > 0) {
            $row_matkul = mysqli_fetch_assoc($result_matkul);
        } else {
            die("Query error: " . mysqli_error($conn));
        }
    }

    mysqli_close($conn);
?>

<?php 
    $pageTitle = "Update Mata Kuliah";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>

<div class="p-4 sm:ml-64 mt-8 flex items-center justify-center h-screen">
    <div class="relative w-full max-w-md max-h-full border border-gray-200 rounded-lg shadow-sm sm:p-4 md:p-4 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update Mata Kuliah</h3>
        </div>
        <form action="process/matakuliah-edit.php" method="POST" class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <input type="hidden" name="id" value="<?php echo $row_matkul['id']; ?>">

                    <label for="kode_mk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode MK</label>
                    <select name="kode_mk" id="kode_mk"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option selected="">Selcet Kode MK</option>
                        <option value="PASD-TI042105" <?php echo ($row_matkul['kode_mk']=='PASD-TI042105' ) ? 'selected' : '' ; ?>>PASD-TI042105</option>
                        <option value="ASD-TI042101" <?php echo ($row_matkul['kode_mk']=='ASD-TI042101' ) ? 'selected' : '' ; ?>>ASD-TI042101</option>
                        <option value="BD-TI042103" <?php echo ($row_matkul['kode_mk']=='BD-TI042103' ) ? 'selected' : '' ; ?>>BD-TI042103</option>
                        <option value="SO-TI042102" <?php echo ($row_matkul['kode_mk']=='SO-TI042102' ) ? 'selected' : '' ; ?>>SO-TI042102</option>
                        <option value="PBD-TI042107" <?php echo ($row_matkul['kode_mk']=='PBD-TI042107' ) ? 'selected' : '' ; ?>>PBD-TI042107</option>
                        <option value="PPWEB-TI042108" <?php echo ($row_matkul['kode_mk']=='PPWEB-TI042108' ) ? 'selected' : '' ; ?>>PPWEB-TI042108</option>
                        <option value="PW-TI042104" <?php echo ($row_matkul['kode_mk']=='PW-TI042104' ) ? 'selected' : '' ; ?>>PW-TI042104</option>
                        <option value="KWN-WN040003" <?php echo ($row_matkul['kode_mk']=='KWN-WN040003' ) ? 'selected' : '' ; ?>>KWN-WN040003</option>
                        <option value="POS-TI042106" <?php echo ($row_matkul['kode_mk']=='POS-TI042106' ) ? 'selected' : '' ; ?>>POS-TI042106</option>
                        <option value="MTK-WI040002" <?php echo ($row_matkul['kode_mk']=='MTK-WI040002' ) ? 'selected' : '' ; ?>>MTK-WI040002</option>
                    </select>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mata Kuliah</label>
                    <select name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="">
                        <option selected="">Selcet Matkul</option>
                        <option value="Prak. Alogoritma & Struktur Data" <?php echo ($row_matkul['name']=='Prak. Alogoritma & Struktur Data' ) ? 'selected' : '' ; ?>>Prak. Alogoritma & Struktur Data</option>
                        <option value="Alogoritma & Struktur Data"<?php echo ($row_matkul['name']=='Alogoritma & Struktur Data' ) ? 'selected' : '' ; ?>>Algoritma & Struktur Data</option>
                        <option value="Basis Data" <?php echo ($row_matkul['name']=='Basis Data' ) ? 'selected' : '' ; ?>>Basis Data</option>
                        <option value="Sistem Operasi" <?php echo ($row_matkul['name']=='Sistem Operasi' ) ? 'selected' : '' ; ?>>Sistem Operasi</option>
                        <option value="Prak. Basis Data" <?php echo ($row_matkul['name']=='Prak. Basis Data' ) ? 'selected' : '' ; ?>>Prak. Basis Data</option>
                        <option value="Prak. Pemrograman Web" <?php echo ($row_matkul['name']=='"Prak. Pemrograman Web' ) ? 'selected' : '' ; ?>>Prak. Pemrograman Web</option>
                        <option value="Pemrograman Web" <?php echo ($row_matkul['name']=='Pemrograman Web' ) ? 'selected' : '' ; ?>>Pemrograman Web</option>
                        <option value="Kewarganegaraan" <?php echo ($row_matkul['name']=='Kewarganegaraan' ) ? 'selected' : '' ; ?>>Kewarganegaraan</option>
                        <option value="Prak. Sistem Operasi" <?php echo ($row_matkul['name']=='Prak. Sistem Operasi' ) ? 'selected' : '' ; ?>>Prak. Sistem Operasi</option>
                        <option value="Matematika 2" <?php echo ($row_matkul['name']=='Matematika 2' ) ? 'selected' : '' ; ?>>Matematika 2</option>
                    </select>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="room"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Room</label>
                    <select name="room" id="room"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required="">
                        <option selected="">Selcet Room</option>
                        <option value="A 301" <?php echo ($row_matkul['room']=='A 301' ) ? 'selected' : '' ; ?> >A 301</option>
                        <option value="B 205" <?php echo ($row_matkul['room']=='B 205' ) ? 'selected' : '' ; ?> >B 205</option>
                        <option value="C 105" <?php echo ($row_matkul['room']=='C 105' ) ? 'selected' : '' ; ?> >C 105</option>
                        <option value="C 106" <?php echo ($row_matkul['room']=='C 106' ) ? 'selected' : '' ; ?> >C 106</option>
                        <option value="C 206" <?php echo ($row_matkul['room']=='C 206' ) ? 'selected' : '' ; ?> >C 206</option>
                        <option value="C 307" <?php echo ($row_matkul['room']=='C 307' ) ? 'selected' : '' ; ?> >C 307</option>
                        <option value="SAW-01.05" <?php echo ($row_matkul['room']=='SAW-01.05' ) ? 'selected' : '' ; ?> >SAW-01.05</option>
                    </select>
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
