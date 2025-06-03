<!-- add.php adalah proses dari index.php yang dimana untuk input data mhs,
    yang dimana add.php ini juga terhubung di index-create.php sbg form nya-->
<?php
include '../connection/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_mk = $_POST['kode_mk'];
    $name    = $_POST['name'];
    $room    = $_POST['room'];

    // validasi input data mhs
    $check = "SELECT * FROM matkul WHERE kode_mk='$kode_mk'";
    $result_matkul = mysqli_query($conn, $check);

    // jika data mhs sudah ada, maka redirect ke index.php dengan pesan error
    if (mysqli_num_rows($result_matkul) > 0) {
        header("Location: ../matakuliah.php?error=duplicate");
        exit;
    }

    // insert data ke database pada tabel mahasiswa
    $insert = "INSERT INTO matkul (kode_mk, name, room) VALUES ('$kode_mk', '$name', '$room')";

    // jika berhasil, maka redirect ke index.php dengan pesan success
    if (mysqli_query($conn, $insert)) {
        header("Location: ../matakuliah.php?success=added");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>