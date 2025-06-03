<?php
include '../connection/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM nilai WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: http://localhost/uas-pweb/nilai.php");
        exit();
    } 

    mysqli_close($conn);
}
?>
