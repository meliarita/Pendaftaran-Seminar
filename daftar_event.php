<?php 
session_start();
include 'config/db.php';

// Proteksi: Jika belum login, tendang ke halaman login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

include 'layout/header.php'; 
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="dashboard.php"><i class="bi bi-mortarboard-fill me-2"></i>E-TICKET KAMPUS</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="dashboard.php">Dashboard</a>
            <a class="nav-link active" href="daftar_event.php">Daftar Event</a>
            <a class="nav-link" href="tiket_saya.php">Tiket Saya</a>
            <a class="nav-link text-warning" href="auth/logout.php"><i class="bi bi-box-arrow-right"></i></a>
        </div>
    </div>
</nav>

<div class="container pb-5">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold">Eksplorasi Event</h2>
            <p class="text-muted">Pilih seminar atau workshop yang ingin kamu ikuti.</p>
        </div>
    </div>

    <div class="row">
        <?php
        // Ambil data event dari database
        $query = mysqli_query($conn, "SELECT * FROM events ORDER BY tanggal ASC");
        
        if (mysqli_num_rows($query) == 0) {
            echo '<div class="col-12 text-center py-5"><h5 class="text-muted">Belum ada event yang tersedia saat ini.</h5></div>';
        }

        while ($event = mysqli_fetch_assoc($query)) :
        ?>
        <div class="card-footer bg-white border-0 pb-3">
            <?php if ($event['kuota'] > 0) : ?>
                <form action="auth/proses_daftar_event.php" method="POST">
                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                    <button type="submit" name="daftar" class="btn btn-primary w-100 rounded-pill shadow-sm">
                        Daftar Sekarang
                    </button>
                </form>
            <?php else : ?>
                <button class="btn btn-danger w-100 rounded-pill shadow-sm" disabled>
                    <i class="bi bi-x-circle me-1"></i> Kuota Penuh
                </button>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'layout/footer.php'; ?>