<!-- materi-add.php adalah proses dari materi.php yang dimana dosen dapat menambah data materi agar
    bisa di akses oleh mahasiswa, yang dimana materi-add.php ini juga terhubung di materi-create.php sbg form nya-->
<?php
session_start();
include '../connection/koneksi.php';
date_default_timezone_set('Asia/Jakarta'); 

$uploadDir = '../files/submission/';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $tugas_id = $_POST['tugas_id'];
    $matkul_id = $_POST['matkul_id'];
    $nilai = isset($_POST['nilai']) && $_POST['nilai'] !== '' ? $_POST['nilai'] : 0;
    
    $mahasiswa_id = $_SESSION['user_id'];

    $fileName = $_FILES['submit-file']['name'];
    $tmpName = $_FILES['submit-file']['tmp_name'];
    $fileSize = $_FILES['submit-file']['size'];
    $fileType = $_FILES['submit-file']['type'];
    $filePath = $uploadDir . $fileName;

    $result_submit = move_uploaded_file($tmpName, $filePath);

    $content = addslashes($content);
    $fileName = addslashes($fileName);
    $filePath = addslashes($filePath);

    $dateNow = date('Y-m-d H:i:s');
    $insert_submit = "INSERT INTO submissions (mahasiswa_id, tugas_id, matkul_id, name, size, type, content, path, nilai, date)
        VALUES ('$mahasiswa_id', '$tugas_id', '$matkul_id', '$fileName', '$fileSize', '$fileType', '$content', '$filePath', $nilai, '$dateNow')";

    if (mysqli_query($conn, $insert_submit)) {
        header("Location: ../tugas-view.php?id=".$tugas_id."&success=added");
        exit();
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>