<?php
    include '../connection/koneksi.php';
    session_start();

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = '$username' AND password ='$password'";
        $result = mysqli_query($conn,$sql);

        if (mysqli_num_rows($result) == 1) {
            $users = mysqli_fetch_assoc($result);
            $_SESSION['user_login'] = true;
            $_SESSION['username'] = $users['username'];
            $_SESSION['user_id'] = $users['user_id'];
            $_SESSION['role'] = $users['role'];
            if ($users['role'] == 'lecturer') {
                $sqlLecturer = "SELECT * FROM lecturer WHERE id = '" . $users['user_id'] . "'";
                $resultLecturer = mysqli_query($conn, $sqlLecturer);
                if (mysqli_num_rows($resultLecturer) == 1) {
                    $lecturer = mysqli_fetch_assoc($resultLecturer);
                    $_SESSION['nip'] = $lecturer['nip'];
                    $_SESSION['name'] = $lecturer['name'];
                    header("Location: http://localhost/uas-pweb/dashboard.php");
                    exit();
                } 
            } elseif ($users['role']  == 'mahasiswa') {
                $sqlStudent = "SELECT * FROM mahasiswa WHERE id = '" . $users['user_id'] . "'";
                $resultStudent = mysqli_query($conn, $sqlStudent);
                if (mysqli_num_rows($resultStudent) == 1) {
                    $student = mysqli_fetch_assoc($resultStudent);
                    $_SESSION['nrp'] = $student['nrp'];
                    $_SESSION['name'] = $student['name'];
                    header("Location: http://localhost/uas-pweb/dashboard.php");
                    exit();
                }     
            }
            header("Location: http://localhost/uas-pweb/dashboard.php");
            exit();    
        }
    } else {
        header("Location: http://localhost/uas-pweb/login.php");
        exit();
    }
    
?>