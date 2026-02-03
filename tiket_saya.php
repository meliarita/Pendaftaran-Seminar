<?php 
session_start();
include 'config/db.php';

// Proteksi: Jika belum login, dialihkan ke login
if (!isset($_SESSION['login'])) { 
    header("Location: index.php"); 
    exit; 
}

include 'layout/header.php'; 
$username = $_SESSION['user'];

// Ambil data pendaftaran milik user yang sedang login dengan JOIN ke tabel events
$query = "SELECT p.*, e.nama_event, e.tanggal, e.kategori 
          FROM pendaftaran p
          JOIN users u ON p.user_id = u.id
          JOIN events e ON p.event_id = e.id
          WHERE u.username = '$username'
          ORDER BY p.tgl_daftar DESC";
$result = mysqli_query($conn, $query);
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-mortarboard-fill me-2"></i>E-TICKET KAMPUS</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link" href="daftar_event.php">Daftar Event</a>
            <a class="nav-link active" href="tiket_saya.php">Tiket Saya</a>
            <a class="nav-link text-warning" href="auth/logout.php"><i class="bi bi-box-arrow-right"></i></a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold">Tiket & Sertifikat Saya</h2>
            <p class="text-muted">Koleksi tiket event yang telah kamu daftarkan.</p>
        </div>
    </div>

    <div class="row">
        <?php while($row = mysqli_fetch_assoc($result)) : ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-soft h-100 overflow-hidden" style="border-radius: 20px;">
                <div class="bg-primary text-white p-4 text-center">
                    <div class="bg-white d-inline-block p-2 rounded-3 mb-2">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= $row['kode_tiket']; ?>" alt="QR Code" class="img-fluid">
                    </div>
                    <h5 class="mb-0 fw-bold letter-spacing-2"><?= $row['kode_tiket']; ?></h5>
                </div>

                <div class="card-body">
                    <span class="badge bg-primary-subtle text-primary mb-2"><?= $row['kategori']; ?></span>
                    <h5 class="card-title fw-bold text-dark mb-3"><?= $row['nama_event']; ?></h5>
                    
                    <div class="d-flex align-items-center text-muted mb-2 small">
                        <i class="bi bi-calendar3 me-2 text-primary"></i>
                        <?= date('d M Y', strtotime($row['tanggal'])); ?>
                    </div>
                    <div class="d-flex align-items-center text-muted mb-4 small">
                        <i class="bi bi-check-circle me-2 text-primary"></i>
                        Status: <strong><?= $row['status_kehadiran']; ?></strong>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="cetak_tiket.php?id=<?= $row['id']; ?>" class="btn btn-outline-primary btn-sm rounded-pill py-2">
                            <i class="bi bi-eye me-1"></i> Detail Tiket
                        </a>

                        <?php if ($row['status_kehadiran'] == 'Hadir') : ?>
                            <a href="generate_sertifikat.php?id=<?= $row['id']; ?>" class="btn btn-success btn-sm rounded-pill py-2 shadow-sm">
                                <i class="bi bi-patch-check-fill me-1"></i> Download Sertifikat
                            </a>
                        <?php else : ?>
                            <button class="btn btn-light btn-sm rounded-pill py-2 text-muted border" disabled>
                                <i class="bi bi-lock-fill me-1"></i> Sertifikat Terkunci
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        
        <?php if(mysqli_num_rows($result) == 0) : ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-ticket-perforated display-1 text-light mb-3 d-block"></i>
                <h5 class="text-muted">Kamu belum memiliki tiket apapun.</h5>
                <a href="daftar_event.php" class="btn btn-primary rounded-pill mt-3 px-4">Cari Event Sekarang</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'layout/footer.php'; ?>