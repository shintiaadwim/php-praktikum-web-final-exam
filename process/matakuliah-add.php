<!-- matakuliah-add.php adalah proses dari matakuliah.php yang dimana untuk mengupload nama nama matakuliah, 
    kode dan ruangannya yang dimana matakuliah-add.php ini juga terhubung di matakuliah-create.php sbg form nya-->
<?php
include '../connection/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mk = $_POST['kode_mk'];
    $name    = $_POST['name'];
    $room    = $_POST['room'];

    // Validasi input data mhs
    $check = "SELECT * FROM matkul WHERE kode_mk='$kode_mk'";
    $result_matkul = mysqli_query($conn, $check);

    // jika data mhs sudah ada, maka redirect ke matakuliah.php dengan pesan error
    if (mysqli_num_rows($result_matkul) > 0) {
        header("Location: ../matakuliah.php?error=duplicate");
        exit;
    }

    // insert data ke database pada tabel matkul
    $insert = "INSERT INTO matkul (kode_mk, name, room) VALUES ('$kode_mk', '$name', '$room')";

    // Jika berhasil, maka redirect ke matakuliah.php dengan pesan success
    if (mysqli_query($conn, $insert)) {
        header("Location: ../matakuliah.php?success=added");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>