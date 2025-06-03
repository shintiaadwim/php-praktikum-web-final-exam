<?php
include '../connection/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_tugas = "DELETE FROM tugas WHERE id='$id'";

    if (mysqli_query($conn, $sql_tugas)) {
        header("Location: http://localhost/uas-pweb/tugas.php");
        exit();
    } 

    mysqli_close($conn);
}
?>
