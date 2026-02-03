<?php
session_start();
include 'config/db.php';

// Proteksi Admin: Pastikan hanya admin yang bisa akses
if (!isset($_SESSION['admin_login'])) {
    header("Location: admin_login.php");
    exit;
}

// Query mengambil data pendaftaran dengan JOIN (Nama User, Nama Event) & Status Kehadiran
$query = "SELECT p.id, u.username, e.nama_event, p.kode_tiket, p.tgl_daftar, p.status_kehadiran 
          FROM pendaftaran p
          JOIN users u ON p.user_id = u.id
          JOIN events e ON p.event_id = e.id
          ORDER BY p.tgl_daftar DESC";
$result = mysqli_query($conn, $query);

include 'layout/header.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="admin_dashboard.php"><i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL</a>
        <div class="navbar-nav ms-auto">
            <a href="admin_dashboard.php" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Dashboard
            </a>
        </div>
    </div>
</nav>

<div class="container py-5">
    
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3 class="fw-bold mb-0">Verifikasi & Kehadiran</h3>
            <p class="text-muted">Validasi pendaftaran dan konfirmasi kehadiran untuk sertifikat.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="export_excel.php" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="bi bi-file-earmark-excel me-2"></i>Download Laporan
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="mb-0 fw-bold text-primary">Daftar Pendaftar Aktif</h5>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control bg-light border-0" placeholder="Cari nama atau tiket...">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="pendaftarTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Peserta</th>
                            <th>Event</th>
                            <th>Kode Tiket</th>
                            <th>Status Kehadiran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($result)) : 
                        ?>
                        <tr>
                            <td class="ps-4"><?= $no++; ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($row['username']); ?></div>
                                <small class="text-muted"><?= date('d/m/y H:i', strtotime($row['tgl_daftar'])); ?></small>
                            </td>
                            <td><?= htmlspecialchars($row['nama_event']); ?></td>
                            <td>
                                <code class="fw-bold text-primary"><?= $row['kode_tiket']; ?></code>
                            </td>
                            <td>
                                <?php if($row['status_kehadiran'] == 'Hadir') : ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                        <i class="bi bi-check-circle-fill me-1"></i> Hadir
                                    </span>
                                <?php else : ?>
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">
                                        <i class="bi bi-clock-history me-1"></i> Belum Hadir
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group">
                                    <?php if($row['status_kehadiran'] != 'Hadir') : ?>
                                        <a href="auth/konfirmasi_kehadiran.php?id=<?= $row['id']; ?>" 
                                           class="btn btn-sm btn-warning shadow-sm" 
                                           onclick="return confirm('Konfirmasi kehadiran peserta ini? Sertifikat akan otomatis tersedia untuk mereka.')">
                                            Konfirmasi Hadir
                                        </a>
                                    <?php endif; ?>

                                    <a href="auth/hapus_pendaftaran.php?id=<?= $row['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('Hapus pendaftaran ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelector('#pendaftarTable tbody').rows;

    for (let i = 0; i < rows.length; i++) {
        let text = rows[i].textContent.toLowerCase();
        rows[i].style.display = text.includes(filter) ? "" : "none";
    }
});
</script>

<?php include 'layout/footer.php'; ?>