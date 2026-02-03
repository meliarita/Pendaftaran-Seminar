<?php
session_start();
include 'config/db.php';
if (!isset($_SESSION['login'])) { header("Location: index.php"); exit; }

$id = $_GET['id'];
$query = "SELECT p.*, e.nama_event, e.tanggal, u.username 
          FROM pendaftaran p
          JOIN users u ON p.user_id = u.id
          JOIN events e ON p.event_id = e.id
          WHERE p.id = '$id' AND p.status_kehadiran = 'Hadir'";
$data = mysqli_fetch_assoc(mysqli_query($conn, $query));

if (!$data) { echo "Sertifikat belum tersedia."; exit; }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat - <?= $data['username']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cert-container {
            width: 800px; height: 550px; padding: 50px;
            margin: 50px auto; border: 15px solid #0d6efd;
            background: #fff; position: relative; text-align: center;
        }
        .cert-bg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.05; z-index: 0; }
        .cert-content { position: relative; z-index: 1; }
        @media print { .no-print { display: none; } body { background: white; } }
    </style>
</head>
<body class="bg-light">

<div class="text-center mt-5 no-print">
    <button onclick="window.print()" class="btn btn-primary px-4 rounded-pill">Download / Print PDF</button>
    <a href="tiket_saya.php" class="btn btn-secondary px-4 rounded-pill">Kembali</a>
</div>

<div class="cert-container shadow-lg">
    <div class="cert-content">
        <h1 class="display-3 fw-bold text-primary mb-0">SERTIFIKAT</h1>
        <p class="lead text-muted">PENGHARGAAN DIBERIKAN KEPADA</p>
        
        <div class="my-4">
            <h2 class="text-dark border-bottom d-inline-block px-5 pb-2"><?= strtoupper($data['username']); ?></h2>
        </div>
        
        <p class="fs-5 mt-4">Atas partisipasi aktifnya sebagai <strong>PESERTA</strong> dalam kegiatan:</p>
        <h3 class="fw-bold text-uppercase"><?= $data['nama_event']; ?></h3>
        
        <p class="mt-4">Dilaksanakan pada tanggal <?= date('d F Y', strtotime($data['tanggal'])); ?></p>
        
        <div class="row mt-5">
            <div class="col-6">
                <p class="mb-0 small">Panitia Pelaksana,</p>
                <div class="my-2 border-bottom w-50 mx-auto"></div>
                <p class="fw-bold">Admin Event Kampus</p>
            </div>
            <div class="col-6 text-center">
                 <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=VERIFIED-<?= $data['kode_tiket']; ?>" alt="QR Code" class="img-thumbnail">
                 <p class="small text-muted mt-1">Verified Certificate</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>