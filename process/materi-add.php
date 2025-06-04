<!-- materi-add.php adalah proses dari materi.php yang dimana dosen dapat menambah materi agar bisa di akses oleh
    mahasiswa dan bisa di lihat admin juga, yang dimana materi-add.php ini juga terhubung di materi-create.php sbg form nya-->
<?php
include '../connection/koneksi.php';
date_default_timezone_set('Asia/Jakarta'); 

$uploadDir = '../files/'; // Direktori tempat menyimpan file yang diupload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['name'];
    $content = $_POST['content'];

    $fileName = $_FILES['materi-file']['name'];
    $tmpName = $_FILES['materi-file']['tmp_name'];
    $fileSize = $_FILES['materi-file']['size'];
    $fileType = $_FILES['materi-file']['type'];
    $filePath = $uploadDir . $fileName; // Path lengkap untuk menyimpan file

    $result_materi = move_uploaded_file($tmpName, $filePath); // Pindahkan file ke direktori yang ditentukan

    $title = addslashes($title);
    $content = addslashes($content);
    $fileName = addslashes($fileName);
    $filePath = addslashes($filePath); 

    $dateNow = date('Y-m-d H:i:s'); // Mendapatkan tanggal dan waktu saat ini
    $insert = "INSERT INTO materi (name, size, type, content, path, date)
            VALUES ('$title', '$fileSize', '$fileType', '$content', '$filePath', '$dateNow')";
    
    // Jika berhasil, maka redirect ke materi.php dengan pesan success
    if (mysqli_query($conn, $insert)) {
        header("Location: ../materi.php?success=added");
        exit();
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>