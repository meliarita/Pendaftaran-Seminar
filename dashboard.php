<?php
session_start();
include 'config/db.php';

// 1. KEAMANAN: Cek apakah sudah login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

// Ambil data dari session
$username = $_SESSION['user'];
$user_id = $_SESSION['user_id'] ?? 0;

// Tentukan apakah dia Admin atau User (Bisa berdasarkan username atau kolom role)
$is_admin = ($username == 'admin'); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Seminar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .card-custom { border: none; border-radius: 15px; transition: 0.3s; }
        .card-custom:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg <?= $is_admin ? 'navbar-dark bg-dark' : 'navbar-dark bg-primary' ?> shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="bi bi-mortarboard-fill me-2"></i> SEMINAR PANEL
        </a>
        <div class="navbar-nav ms-auto align-items-center">
            <span class="nav-link text-white me-3">Halo, <strong><?= $username; ?></strong></span>
            <a href="auth/logout.php" class="btn btn-danger btn-sm rounded-pill px-3" onclick="return confirm('yakin ingin Keluar?')">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">

    <?php if ($is_admin) : ?>
        <h2 class="fw-bold mb-4">Dashboard Admin</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card card-custom shadow-sm p-4 text-center">
                    <i class="bi bi-qr-code-scan display-4 text-success mb-3"></i>
                    <h5>Scan Presensi</h5>
                    <p class="text-muted small">Absensi peserta menggunakan QR Code.</p>
                    <a href="admin_scan.php" class="btn btn-success w-100 rounded-pill">Buka Kamera</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-custom shadow-sm p-4 text-center">
                    <i class="bi bi-people display-4 text-primary mb-3"></i>
                    <h5>Data Peserta</h5>
                    <p class="text-muted small">Lihat dan kelola data pendaftar.</p>
                    <a href="admin_peserta.php" class="btn btn-primary w-100 rounded-pill">Lihat Data</a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card card-custom shadow-sm p-4 text-center">
                    <i class="bi bi-calendar-plus display-4 text-dark mb-3"></i>
                    <h5>Tambah Event</h5>
                    <p class="text-muted small">Input jadwal seminar baru.</p>
                    <button class="btn btn-dark w-100 rounded-pill">Tambah Event</button>
                </div>
            </div>
        </div>

    <?php else : ?>
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">Seminar Tersedia</h2>
                <p class="text-secondary">Pilih seminar yang ingin kamu ikuti di bawah ini.</p>
            </div>
        </div>

        <div class="row">
            <?php
            // Ambil semua event dari tabel events
            $query_ev = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
            if (mysqli_num_rows($query_ev) > 0) {
                while ($ev = mysqli_fetch_assoc($query_ev)) {
            ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card card-custom shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="badge bg-primary mb-2">Seminar</div>
                            <h5 class="fw-bold"><?= $ev['nama_event']; ?></h5>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-calendar3 me-1"></i> <?= $ev['tanggal']; ?>
                            </p>
                            
                            <a href="daftar_event.php?id=<?= $ev['id']; ?>" class="btn btn-outline-primary w-100 rounded-pill">
                                <i class="bi bi-pencil-square me-1"></i> Daftar Sekarang
                            </a>

                        </div>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo "<div class='alert alert-warning'>Belum ada event tersedia saat ini.</div>";
            }
            ?>
        </div>
    <?php endif; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>