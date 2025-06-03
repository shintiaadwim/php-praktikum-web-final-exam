<?php
include '../connection/koneksi.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nrp = $_POST['nrp'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'mahasiswa';

    $sqlMahasiswa = "SELECT * FROM mahasiswa WHERE nrp='$nrp' AND name='$name'";
    $resultMahasiswa = mysqli_query($conn, $sqlMahasiswa);

    if (mysqli_num_rows($resultMahasiswa) > 0) {
        $data = mysqli_fetch_assoc($resultMahasiswa);
        $user_id = $data['id'];
        
        $sqlUsers = "INSERT INTO users (user_id, username, password, role) VALUES ('$user_id', '$username', '$password', '$role')";
        if (mysqli_query($conn, $sqlUsers)) {
            $user_id = mysqli_insert_id($conn);
            header("Location: http://localhost/uas-pweb/login.php");
        } 
    }

}
?>
