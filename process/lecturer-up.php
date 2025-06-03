<?php
include '../connection/koneksi.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = $_POST['nip'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'lecturer';

    $sqlLecturer = "SELECT * FROM lecturer WHERE nip='$nip' AND name='$name'";
    $resultLecturer = mysqli_query($conn, $sqlLecturer);
    
    if (mysqli_num_rows($resultLecturer) > 0) {
        $data = mysqli_fetch_assoc($resultLecturer);
        $user_id = $data['id'];
        
        $sqlUsers = "INSERT INTO users (user_id, username, password, role) VALUES ('$user_id', '$username', '$password', '$role')";
        if (mysqli_query($conn, $sqlUsers)) {
            $user_id = mysqli_insert_id($conn);
            header("Location: http://localhost/uas-pweb/login.php");
        } 
    }

}
?>