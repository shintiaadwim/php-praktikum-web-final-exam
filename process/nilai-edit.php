<?php
session_start();
include '../connection/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $id = $_POST['id'];
    $mahasiswa_id = $_POST['mahasiswa_id']; // tambahkan ini di form HTML juga
    $pasd   = $_POST['pasd'];
    $asd    = $_POST['asd'];
    $bd     = $_POST['bd'];
    $os     = $_POST['os'];
    $pbd    = $_POST['pbd'];
    $ppweb  = $_POST['ppweb'];
    $pweb   = $_POST['pweb'];
    $kwn    = $_POST['kwn'];
    $pos    = $_POST['pos'];
    $mtk    = $_POST['mtk'];

    // Cek apakah data nilai untuk mahasiswa_id sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM nilai WHERE mahasiswa_id = '$mahasiswa_id'");
    
    if (mysqli_num_rows($cek) > 0) {
        // Jika data sudah ada → UPDATE
        $sql_nilai = "UPDATE nilai SET 
            pasd='$pasd', asd='$asd', bd='$bd', os='$os', pbd='$pbd', 
            ppweb='$ppweb', pweb='$pweb', kwn='$kwn', pos='$pos', mtk='$mtk' 
            WHERE mahasiswa_id='$mahasiswa_id'";
        
        if (mysqli_query($conn, $sql_nilai)) {
            header("Location: ../nilai.php?success=updated");
        } else {
            echo "Gagal mengupdate data: " . mysqli_error($conn);
        }
    } else {
        // Jika belum ada → INSERT
        $sql_nilai = "INSERT INTO nilai (mahasiswa_id, pasd, asd, bd, os, pbd, ppweb, pweb, kwn, pos, mtk)
                VALUES ('$mahasiswa_id', '$pasd', '$asd', '$bd', '$os', '$pbd', '$ppweb', '$pweb', '$kwn', '$pos', '$mtk')";

        if (mysqli_query($conn, $sql_nilai)) {
            header("Location: ../nilai.php?success=added");
        } else {
            echo "Gagal menambahkan data: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>
