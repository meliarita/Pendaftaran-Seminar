<?php
session_start();
include '../config/db.php';

if (isset($_POST['reset_password'])) {
    // 1. Ambil data dari form lupa_password.php
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $jawaban_keamanan = mysqli_real_escape_string($conn, $_POST['jawaban_keamanan']);
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // 2. Validasi: Apakah password baru dan konfirmasi cocok?
    if ($password_baru !== $konfirmasi_password) {
        echo "<script>alert('Konfirmasi password baru tidak cocok!'); window.history.back();</script>";
        exit;
    }

    // 3. Cek apakah Username dan Jawaban Keamanan sesuai di database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND jawaban_keamanan = '$jawaban_keamanan'");
    
    if (mysqli_num_rows($query) > 0) {
        // 4. Jika cocok, update password lama menjadi password baru
        // (Gunakan password_hash jika Anda menggunakan enkripsi, tapi di sini kita pakai plain text sesuai login sebelumnya)
        $update = mysqli_query($conn, "UPDATE users SET password = '$password_baru' WHERE username = '$username'");

        if ($update) {
            echo "<script>alert('Password berhasil direset! Silakan login kembali.'); window.location='../index.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui database.'); window.history.back();</script>";
        }
    } else {
        // 5. Jika username atau jawaban keamanan salah
        echo "<script>alert('Username atau Jawaban Keamanan salah! Silakan coba lagi.'); window.history.back();</script>";
    }
} else {
    header("Location: ../lupa_password.php");
    exit;
}
?>