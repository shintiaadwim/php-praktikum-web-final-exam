<?php
    session_start();
    include 'connection/koneksi.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql_nilai = "SELECT m.id AS mhs_id, m.nrp, m.name, n.id AS nilai_id, n.pasd, n.asd, n.bd, n.os, n.pbd, n.ppweb, n.pweb, n.kwn, n.pos, n.mtk
            FROM mahasiswa AS m
            LEFT JOIN nilai AS n ON m.id = n.mahasiswa_id
            WHERE m.id = $id";

        $result_nilai = mysqli_query($conn, $sql_nilai);

        if (!$result_nilai) {
            die('SQL error: ' . mysqli_error($conn));
        }

        if (mysqli_num_rows($result_nilai) > 0) {
            $row_nilai = mysqli_fetch_assoc($result_nilai);
        } else {
            echo "<p style='color:red;'>Data tidak ditemukan.</p>";
            exit;
        }
    }
?>

<?php 
    $pageTitle = "Update Data Nilai";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>

<div class="p-4 sm:ml-64 mt-8 flex items-center justify-center h-screen">
    <div class="relative w-full max-w-md max-h-full border border-gray-200 rounded-lg shadow-sm sm:p-4 md:p-4 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Update data nilai</h3>
        </div>

        <form action="process/nilai-edit.php" method="POST" class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2 sm:col-span-1">
                    <input type="hidden" name="id" value="<?php echo $row_nilai['nilai_id']; ?>">
                    <input type="hidden" name="mahasiswa_id" value="<?php echo $row_nilai['mhs_id']; ?>">

                    <label for="nrp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NRP</label>
                    <input type="number" name="nrp" id="nrp" value="<?php echo $row_nilai['nrp']; ?>" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="NRP student" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $row_nilai['name']; ?>" readonly
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Name student" required>
                </div>
            </div>

            <div class="grid gap-4 mb-4 grid-cols-5">
                <div class="col-span-2 sm:col-span-1">
                    <label for="pasd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PASD</label>
                    <input type="number" name="pasd" id="pasd" value="<?php echo $row_nilai['pasd']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="PASD" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="asd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ASD</label>
                    <input type="number" name="asd" id="asd" value="<?php echo $row_nilai['asd']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="ASD" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="bd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">BD</label>
                    <input type="number" name="bd" id="bd" value="<?php echo $row_nilai['bd']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="BD" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="os" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">OS</label>
                    <input type="number" name="os" id="os" value="<?php echo $row_nilai['os']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="OS" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="pbd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PBD</label>
                    <input type="number" name="pbd" id="pbd" value="<?php echo $row_nilai['pbd']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="PBD" required>
                </div>
            </div>

            <div class="grid gap-4 mb-4 grid-cols-5">
                <div class="col-span-2 sm:col-span-1">
                    <label for="ppweb" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PPWEB</label>
                    <input type="number" name="ppweb" id="ppweb" value="<?php echo $row_nilai['ppweb']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="PPWEB" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="pweb" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PWEB</label>
                    <input type="number" name="pweb" id="pweb" value="<?php echo $row_nilai['pweb']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="PWEB" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="kwn" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">KWN</label>
                    <input type="number" name="kwn" id="kwn" value="<?php echo $row_nilai['kwn']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="KWN" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="pos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">POS</label>
                    <input type="number" name="pos" id="pos" value="<?php echo $row_nilai['pos']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="POS" required>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label for="mtk" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">MTK</label>
                    <input type="number" name="mtk" id="mtk" value="<?php echo $row_nilai['mtk']; ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="MTK" required>
                </div>
            </div>
            <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Update
            </button>
        </form>
    </div>
</div>
