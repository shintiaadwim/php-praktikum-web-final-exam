<!-- index-up.php adalah proses dari index-register.php yang dimana untuk login sebagai mhs -->
<?php
include '../connection/koneksi.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nrp = $_POST['nrp'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'mahasiswa';

    // Validasi input dari database mahasiswa yang sudah ada
    $sqlMahasiswa = "SELECT * FROM mahasiswa WHERE nrp='$nrp' AND name='$name'";
    $resultMahasiswa = mysqli_query($conn, $sqlMahasiswa);

    if (mysqli_num_rows($resultMahasiswa) > 0) {
        $data = mysqli_fetch_assoc($resultMahasiswa);
        $user_id = $data['id'];
        
        // Jika data mahasiswa sudah ada, maka buat akun user baru
        $sqlMahasiswa = "INSERT INTO users (user_id, username, password, role) VALUES ('$user_id', '$username', '$password', '$role')";
        if (mysqli_query($conn, $sqlMahasiswa)) {
            $user_id = mysqli_insert_id($conn);
            header("Location: http://localhost/uas-pweb/login.php");
        } 
    }

}
?>
