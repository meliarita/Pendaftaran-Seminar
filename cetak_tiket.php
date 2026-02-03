<?php
session_start();
include 'config/db.php';
if (!isset($_SESSION['login'])) { header("Location: index.php"); exit; }

$id = $_GET['id'];
$query = "SELECT p.*, e.nama_event, e.tanggal, e.kategori, u.username 
          FROM pendaftaran p
          JOIN users u ON p.user_id = u.id
          JOIN events e ON p.event_id = e.id
          WHERE p.id = '$id'";
$data = mysqli_fetch_assoc(mysqli_query($conn, $query));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket - <?= $data['kode_tiket']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .ticket-box {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .ticket-header { background: #0d6efd; color: white; padding: 30px; text-align: center; }
        .ticket-body { padding: 40px; border-bottom: 2px dashed #e0e0e0; position: relative; }
        .ticket-footer { padding: 20px; text-align: center; background: #fafafa; }
        /* Variasi Dot untuk sobekan tiket */
        .ticket-body::before, .ticket-body::after {
            content: ''; position: absolute; bottom: -15px; width: 30px; height: 30px;
            background: #f0f2f5; border-radius: 50%;
        }
        .ticket-body::before { left: -15px; }
        .ticket-body::after { right: -15px; }
    </style>
</head>
<body>

<div class="container text-center mb-3 mt-5 no-print">
    <button onclick="window.print()" class="btn btn-dark rounded-pill px-4"><i class="bi bi-printer"></i> Cetak / Simpan PDF</button>
    <a href="tiket_saya.php" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
</div>

<div class="ticket-box">
    <div class="ticket-header">
        <h4 class="mb-0 fw-bold">E-TICKET EVENT KAMPUS</h4>
        <small>Tunjukkan tiket ini saat registrasi di lokasi</small>
    </div>
    
    <div class="ticket-body">
        <div class="row align-items-center text-center text-md-start">
            <div class="col-md-8">
                <h2 class="fw-bold text-primary mb-1"><?= $data['nama_event']; ?></h2>
                <span class="badge bg-secondary mb-3"><?= $data['kategori']; ?></span>
                
                <div class="mb-2">
                    <small class="text-muted d-block text-uppercase">Nama Peserta</small>
                    <h5 class="fw-bold"><?= strtoupper($data['username']); ?></h5>
                </div>
                
                <div class="mb-0">
                    <small class="text-muted d-block text-uppercase">Waktu Pelaksanaan</small>
                    <h5 class="fw-bold"><?= date('l, d F Y', strtotime($data['tanggal'])); ?></h5>
                </div>
            </div>
            <div class="col-md-4 text-center mt-4 mt-md-0">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= $data['kode_tiket']; ?>" alt="QR Code" class="img-fluid shadow-sm p-2 bg-white">
                <p class="mt-2 fw-bold text-muted small"><?= $data['kode_tiket']; ?></p>
            </div>
        </div>
    </div>
    
    <div class="ticket-footer">
        <p class="small text-muted mb-0">Tiket ini diterbitkan secara otomatis oleh Sistem Event Kampus.</p>
    </div>
</div>

<style type="text/css">
    @media print {
        .no-print { display: none; }
        body { background: white; }
        .ticket-box { box-shadow: none; border: 1px solid #ddd; margin: 0; }
    }
</style>

</body>
</html>