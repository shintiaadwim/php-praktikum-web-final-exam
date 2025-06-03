<!-- edit.php adalah proses dari index.php yang dimana untuk mengedit data mhs,
    yang dimana edit.php ini juga terhubung di index.update.php sbg form nya -->
<?php
include '../connection/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id         = $_POST['id']; 
    $nrp        = $_POST['nrp'];
    $name       = $_POST['name'];
    $age        = $_POST['age'];
    $gender     = $_POST['gender'];
    $address    = $_POST['address'];

    $sql_mhs = "UPDATE mahasiswa SET nrp='$nrp', name='$name', age='$age', gender='$gender', address='$address' WHERE id='$id'";

    if (mysqli_query($conn, $sql_mhs)) {
        header("Location: http://localhost/uas-pweb/index.php");
        exit();
    }

    mysqli_close($conn);
}
?>
