<?php
include '../connection/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_mhs = "DELETE FROM mahasiswa WHERE id='$id'";

    if (mysqli_query($conn, $sql_mhs)) {
        header("Location: http://localhost/uas-pweb/index.php");
        exit();
    } 

    mysqli_close($conn);
}
?>
