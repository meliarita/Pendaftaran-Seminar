<?php
include '../config/db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berhasil Daftar!'); window.location='../index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>