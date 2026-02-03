<?php
session_start();
// Menghubungkan ke database. ../ karena db.php ada di luar folder auth
include '../config/db.php'; 

if (isset($_POST['login'])) {
    // Mengambil data dari form index.php
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // 1. Cari user berdasarkan username
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // 2. Cek apakah password cocok (Tanpa hashing agar sesuai dengan proses register sebelumnya)
        if ($password === $data['password']) {
            
            // 3. Set Session untuk keamanan akses halaman lain
            $_SESSION['login'] = true;
            $_SESSION['user'] = $data['username'];
            $_SESSION['user_id'] = $data['id']; // Penting untuk filter Tiket Saya

            // 4. Arahkan ke Dashboard
            header("Location: ../dashboard.php");
            exit;
        } else {
            // Password tidak sesuai
            echo "<script>alert('Password yang Anda masukkan salah!'); window.history.back();</script>";
        }
    } else {
        // Username tidak ditemukan
        echo "<script>alert('Username tidak terdaftar!'); window.history.back();</script>";
    }
} else {
    // Jika diakses tanpa submit form
    header("Location: ../index.php");
    exit;
}
?>