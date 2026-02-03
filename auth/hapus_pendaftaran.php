<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['admin_login'])) { exit; }

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil event_id dulu sebelum data pendaftaran dihapus
    $data = mysqli_query($conn, "SELECT event_id FROM pendaftaran WHERE id = $id");
    $row = mysqli_fetch_assoc($data);
    $event_id = $row['event_id'];

    // Hapus pendaftaran
    $delete = mysqli_query($conn, "DELETE FROM pendaftaran WHERE id = $id");
    
    if ($delete) {
        // TAMBAHKAN KEMBALI KUOTANYA
        mysqli_query($conn, "UPDATE events SET kuota = kuota + 1 WHERE id = '$event_id'");
        header("Location: ../verifikasi_peserta.php");
    }
}
?>