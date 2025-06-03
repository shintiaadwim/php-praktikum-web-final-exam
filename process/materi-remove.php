<?php
include '../connection/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_materi = "DELETE FROM materi WHERE id='$id'";

    if (mysqli_query($conn, $sql_materi)) {
        header("Location: http://localhost/uas-pweb/materi.php");
        exit();
    } 

    mysqli_close($conn);
}
?>
