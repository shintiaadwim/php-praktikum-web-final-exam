<?php
include '../connection/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_matkul = "DELETE FROM matkul WHERE id='$id'";

    if (mysqli_query($conn, $sql_matkul)) {
        header("Location: http://localhost/uas-pweb/matakuliah.php");
        exit();
    } 

    mysqli_close($conn);
}
?>
