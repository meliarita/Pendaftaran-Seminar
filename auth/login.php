<?php
session_start();
include '../config/db.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = $row['username'];
            header("Location: ../dashboard.php");
            exit;
        }
    }
    echo "<script>alert('Username/Password Salah!'); window.location='../index.php';</script>";
}
?>