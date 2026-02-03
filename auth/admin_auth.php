<?php
session_start();
include '../config/db.php';

if (isset($_POST['login_admin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek kecocokan username dan password secara langsung (tanpa hashing)
    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['admin_login'] = true;
        $_SESSION['admin_user'] = $username;
        header("Location: ../admin_dashboard.php");
        exit;
    } else {
        echo "<script>alert('Akses Admin Ditolak!'); window.location='../admin_login.php';</script>";
    }
}
?>