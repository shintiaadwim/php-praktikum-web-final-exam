<!-- add.php adalah proses dari index.php yang dimana untuk input data mhs,
    yang dimana add.php ini juga terhubung di index-create.php sbg form nya-->
<?php
include '../connection/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nrp     = $_POST['nrp'];
    $name    = $_POST['name'];
    $age     = $_POST['age'];
    $gender  = $_POST['gender'];
    $address = $_POST['address'];

    // validasi input data mhs
    $check = "SELECT * FROM mahasiswa WHERE nrp='$nrp'";
    $result_mhs = mysqli_query($conn, $check);

    // jika data mhs sudah ada, maka redirect ke index.php dengan pesan error
    if (mysqli_num_rows($result_mhs) > 0) {
        header("Location: ../index.php?error=duplicate");
        exit;
    }

    // insert data ke database pada tabel mahasiswa
    $insert = "INSERT INTO mahasiswa (nrp, name, age, gender, address)
                VALUES ('$nrp', '$name', '$age', '$gender', '$address')";

    // jika berhasil, maka redirect ke index.php dengan pesan success
    if (mysqli_query($conn, $insert)) {
        header("Location: ../index.php?success=added");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>