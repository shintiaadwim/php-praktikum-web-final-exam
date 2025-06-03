<?php
session_start();
include '../connection/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nilai']) && isset($_POST['id']) && isset($_POST['tugas_id'])) {
        $nilai = intval($_POST['nilai']);
        $id = intval($_POST['id']);
        $tugas_id = intval($_POST['tugas_id']);

        $update = mysqli_query($conn, "UPDATE submissions SET nilai = $nilai WHERE id = $id");

        if ($update) {
            header("Location: http://localhost/uas-pweb/tugas-view.php?id=$tugas_id");
            exit;
        }
    } else {
        echo "Data tidak lengkap.";
    }
    mysqli_close($conn);
}
?>