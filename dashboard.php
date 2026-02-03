<?php
session_start();
include 'config/db.php';

// Pastikan hanya yang sudah login yang bisa masuk
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

// Ambil data untuk statistik ringkas (Opsional)
$total_peserta = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users"));
$total_hadir = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM pendaftaran WHERE status_kehadiran = 'Hadir'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pendaftaran Seminar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .menu-card {
            transition: transform 0.2s;
            cursor: pointer;
        }
        .menu-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">
        <a class="navbar-brand" href="#">Sistem Seminar</a>
        <div class="navbar-nav ms-auto">
            <span class="nav-link text-white me-3">Halo, <?= $_SESSION['user']; ?>!</span>
            <a href="auth/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold">Selamat Datang di Dashboard</h2>
            <p class="text-secondary">Kelola data peserta dan lakukan absensi dengan cepat.</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3">
                <h6>Total User</h6>
                <h3><?= $total_peserta; ?></h3>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3">
                <h6>Peserta Hadir</h6>
                <h3><?= $total_hadir; ?></h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm menu-card">
                <div class="card-body text-center py-5">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-qr-code-scan display-5"></i>
                    </div>
                    <h5 class="fw-bold">Scan Presensi</h5>
                    <p class="text-muted px-3">Gunakan kamera untuk memindai tiket peserta seminar.</p>
                    <a href="admin_scan.php" class="btn btn-success rounded-pill px-4 shadow-sm">Buka Scanner</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm menu-card">
                <div class="card-body text-center py-5">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-people-fill display-5"></i>
                    </div>
                    <h5 class="fw-bold">Data Peserta</h5>
                    <p class="text-muted px-3">Lihat dan kelola semua mahasiswa yang terdaftar.</p>
                    <a href="admin_peserta.php" class="btn btn-primary rounded-pill px-4 shadow-sm">Lihat Data</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm menu-card">
                <div class="card-body text-center py-5">
                    <div class="bg-dark bg-opacity-10 text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-gear-fill display-5"></i>
                    </div>
                    <h5 class="fw-bold">Pengaturan</h5>
                    <p class="text-muted px-3">Ubah kuota seminar atau informasi event.</p>
                    <button class="btn btn-dark rounded-pill px-4 shadow-sm">Buka Setting</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>