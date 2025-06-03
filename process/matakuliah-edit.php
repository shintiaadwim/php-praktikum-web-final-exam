<!-- edit.php adalah proses dari index.php yang dimana untuk mengedit data mhs,
    yang dimana edit.php ini juga terhubung di index.update.php sbg form nya -->
<?php
include '../connection/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id       = $_POST['id'];
    $kode_mk  = $_POST['kode_mk'];
    $name     = $_POST['name'];
    $room     = $_POST['room'];

    $sql_matkul = "UPDATE matkul SET kode_mk='$kode_mk', name='$name', room='$room' WHERE id='$id'";

    if (mysqli_query($conn, $sql_matkul)) {
        header("Location: http://localhost/uas-pweb/matakuliah.php");
        exit();
    }

    mysqli_close($conn);
}
?>
