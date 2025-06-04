<?php
    session_start();
    include 'connection/koneksi.php';

    $folder = "files/submission/";  // Folder tempat file submission disimpan
    $file = null;                   // Inisialisasi variabel file

    // Jika ada parameter id, ambil nama file dari database
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = mysqli_query($conn, "SELECT path FROM submissions WHERE id = $id");
        if ($data = mysqli_fetch_assoc($query)) {
            $file = $data['path'];
        }
    }

    // Jika tidak ada id, cek parameter file langsung
    if (!$file) {
        $availableFiles = array_values(array_diff(scandir($folder), array('.', '..'))); // Ambil daftar file yang tersedia di folder
        $defaultFile = count($availableFiles) > 0 ? $availableFiles[0] : null; // Ambil file pertama sebagai pilihan default, jika tidak ada file set ke null
        $file = isset($_GET['file']) && $_GET['file'] !== '' ? $_GET['file'] : $defaultFile; // Mencek apakah ada parameter file, jika tidak ada gunakan file default
    }

    $file = basename($file);        // Mengambil nama file saja untuk keamanan, jadi lokasi filenya tidak bisa diakses sembarangan
    $filePath = $folder . $file;    // Mengetahui lokasi folder dan file (contoh: materi/bab1.pdf)
?>

<?php 
    $pageTitle = "Submission Preview";
    include 'cdn.php';
    include 'layouts/header.php';
    include 'layouts/sidebar.php';
?>

<div class="sm:ml-64 mt-14">
    <div class="p-4">
        <div class="pb-4 text-2xl font-bold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
            Preview Tugas Mahsiswa
            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Pilih file materi untuk ditampilkan.</p>
        </div>
        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['lecturer', 'admin'])): ?>
            <!-- Menampilkan file pada inframe -->
            <?php if ($file && file_exists($filePath)) { ?>
                <!-- #toolbar=1 : untuk menampilkan navigasi file -->
                <iframe src="<?php echo $filePath; ?>#toolbar=1" class="w-full h-[80vh] border rounded" frameborder="0"></iframe>
                    <div class="mt-4">
            <?php } else { ?>
                <div class="bg-red-100 text-red-700 p-4 rounded">
                    File <strong><?php echo htmlspecialchars($file); ?></strong> tidak ditemukan.
                </div>
            <?php } ?>
        <?php endif; ?>
    </div>
    <?php include 'layouts/footer.php'; ?>
</div>
