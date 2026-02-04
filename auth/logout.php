<?php
session_start(); // Memulai sesi agar bisa dihapus

// Menghapus semua variabel session
$_SESSION = array();

// Menghancurkan session di server
session_destroy();

// Mengarahkan kembali ke halaman login utama
echo "<script>
    alert('Anda telah berhasil keluar.');
    window.location.href = '../index.php';
</script>";
exit;
?>