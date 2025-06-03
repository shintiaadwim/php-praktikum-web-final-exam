<!-- lecturer-add.php adalah proses dari lecturer.php yang dimana untuk input data dosen,
    yang dimana lecturer-add.php ini juga terhubung di lecturer-create.php sbg form nya -->
<?php
include '../connection/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip        = $_POST['nip'];
    $name       = $_POST['name'];
    $matakuliah = $_POST['matakuliah'];
    $room       = $_POST['room'];
    $telp       = $_POST['telp'];

    // validasi input data dosen
    $check = "SELECT * FROM lecturer WHERE nip='$nip'";
    $result_lecturer = mysqli_query($conn, $check);

    // jika data dosen sudah ada, maka redirect ke lecturer.php dengan pesan error
    if (mysqli_num_rows($result_lecturer) > 0) {
        header("Location: ../lecturer.php?error=duplicate");
        exit;
    }

    // insert data ke database pada tabel lecturer
    $insert = "INSERT INTO lecturer (nip, name, matakuliah, room, telp)
                VALUES ('$nip', '$name', '$matakuliah', '$room', '$telp')";

    // jika berhasil, maka redirect ke lecturer.php dengan pesan success
    if (mysqli_query($conn, $insert)) {
        header("Location: ../lecturer.php?success=added");
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
