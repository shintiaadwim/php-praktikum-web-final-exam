<!-- tugas-add.php adalah proses dari tugas.php yang dimana dosen dapat mengupload tugas agar bisa di akses oleh
    mahasiswa untuk mengumpulkan tugas serta melihat nilai jika tugas yang terkumpulkan sudah di nilai dosen matkul tsb,
    yang dimana tugas-add.php ini juga terhubung di tugas-create.php sbg form nya-->
<?php
include '../connection/koneksi.php';
date_default_timezone_set('Asia/Jakarta'); 

$uploadDir = '../files/tugas/'; // Direktori tempat menyimpan file yang diupload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['name'];
    $content = $_POST['content'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $matkul_id = $_POST['matkul_id'];
    $dateTime = "$date $time:00";

    // Cek apakah file dilampirkan ada atau tidak
    if (!empty($_FILES['tugas-file']['name'])) {
        $fileName = $_FILES['tugas-file']['name'];
        $tmpName = $_FILES['tugas-file']['tmp_name'];
        $fileSize = $_FILES['tugas-file']['size'];
        $fileType = $_FILES['tugas-file']['type'];
        $filePath = $uploadDir . $fileName;

        $result_tugas = move_uploaded_file($tmpName, $filePath);

        $fileName = addslashes($fileName);
        $filePath = addslashes($filePath);
    } else { // Jika tidak ada file yang diupload, set variabel file menjadi kosong
        $fileName = '';
        $fileSize = 0;
        $fileType = '';
        $filePath = '';
    }

    $title = addslashes($title);
    $content = addslashes($content);
    $matkul_id = intval($matkul_id); 

    $insert = "INSERT INTO tugas (matkul_id, name, size, type, content, path, date)
            VALUES ('$matkul_id', '$title', '$fileSize', '$fileType', '$content', '$filePath', '$dateTime')";

    if (mysqli_query($conn, $insert)) {
        header("Location: ../tugas.php?success=added");
        exit();
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>