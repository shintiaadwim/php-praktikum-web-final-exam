<?php
include '../connection/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql_lecturer = "DELETE FROM lecturer WHERE id='$id'";

    if (mysqli_query($conn, $sql_lecturer)) {
        header("Location: http://localhost/uas-pweb/lecturer.php");
        exit();
    } 

    mysqli_close($conn);
}
?>
