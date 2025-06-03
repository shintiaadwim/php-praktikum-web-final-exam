<!-- lecturer-edit.php adalah proses dari lecturer.php yang dimana untuk mengedit data dosen,
    yang dimana lecturer-edit.php ini juga terhubung di lecturer-update.php sbg form nya -->
<?php
include '../connection/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id         = $_POST['id']; 
    $nip        = $_POST['nip'];
    $name       = $_POST['name'];
    $matakuliah = $_POST['matakuliah'];
    $room       = $_POST['room'];
    $telp       = $_POST['telp'];

    $sql_lecturer = "UPDATE lecturer SET nip='$nip', name='$name', matakuliah='$matakuliah', room='$room', telp='$telp' WHERE id='$id'";

    if (mysqli_query($conn, $sql_lecturer)) {
        header("Location: http://localhost/uas-pweb/lecturer.php");
        exit();
    }

    mysqli_close($conn);
}
?>
