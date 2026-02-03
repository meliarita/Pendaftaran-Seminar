<?php
// Menghubungkan ke database
include '../config/db.php';

if (isset($_POST['register'])) {
    // Mengambil dan membersihkan data dari form pendaftaran
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $jawaban  = mysqli_real_escape_string($conn, $_POST['jawaban']);
    
    // MENGACAK PASSWORD (Keamanan Tinggi)
    // Pastikan panjang kolom password di database minimal 255 karakter
    $password_acak = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah ada sebelumnya agar tidak ganda
    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah digunakan, cari nama lain!'); window.history.back();</script>";
        exit;
    }

    // Query untuk memasukkan data ke tabel users
    // Sesuaikan nama kolom (username, password, nama, jawaban_keamanan) dengan database kamu
    $query = "INSERT INTO users (username, password, jawaban_keamanan) 
              VALUES ('$username', '$password_acak', '$jawaban')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='../index.php';</script>";
    } else {
        // Jika error, akan memunculkan pesan error dari SQL
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika mencoba akses file langsung tanpa klik tombol register
    header("Location: ../register_page.php");
    exit;
}
?>