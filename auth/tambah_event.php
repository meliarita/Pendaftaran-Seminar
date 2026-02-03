<?php
session_start();
include '../config/db.php';

if (isset($_POST['simpan_event'])) {
    $nama    = $_POST['nama_event'];
    $kategori = $_POST['kategori'];
    $tanggal = $_POST['tanggal'];
    $kuota   = $_POST['kuota'];

    $query = "INSERT INTO events (nama_event, kategori, tanggal, kuota, status) 
              VALUES ('$nama', '$kategori', '$tanggal', '$kuota', 'Aktif')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Event Berhasil Ditambahkan!'); window.location='../admin_dashboard.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>