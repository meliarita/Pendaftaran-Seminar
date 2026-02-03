<?php 
session_start();
include 'config/db.php';

// Proteksi Admin: Hanya yang sudah login admin bisa masuk
if (!isset($_SESSION['admin_login'])) {
    header("Location: admin_login.php");
    exit;
}

include 'layout/header.php'; 
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#"><i class="bi bi-shield-lock-fill me-2"></i>ADMIN PANEL</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link text-danger fw-bold" href="auth/logout_admin.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white p-3 rounded-4 shadow-sm d-flex gap-2">
                <a href="admin_dashboard.php" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-grid-1x2-fill me-2"></i>Dashboard & Event
                </a>
                <a href="verifikasi_peserta.php" class="btn btn-outline-primary rounded-pill px-4">
                    <i class="bi bi-people-fill me-2"></i>Verifikasi Pendaftar
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Daftar Mahasiswa</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php
                        $user_query = mysqli_query($conn, "SELECT username FROM users");
                        while($u = mysqli_fetch_assoc($user_query)) :
                        ?>
                        <li class="list-group-item d-flex align-items-center py-3">
                            <i class="bi bi-person-circle fs-4 me-3 text-secondary"></i>
                            <div>
                                <h6 class="mb-0"><?= htmlspecialchars($u['username']); ?></h6>
                                <small class="text-muted">Mahasiswa Aktif</small>
                            </div>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Manajemen Event</h5>
                    <button class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambahEvent">
                        <i class="bi bi-plus-lg me-1"></i> Buat Event
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Event</th>
                                    <th>Kategori</th>
                                    <th>Kuota</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ev_query = mysqli_query($conn, "SELECT * FROM events ORDER BY id DESC");
                                while($ev = mysqli_fetch_assoc($ev_query)) :
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?= htmlspecialchars($ev['nama_event']); ?></div>
                                        <small class="text-muted"><i class="bi bi-calendar-event me-1"></i><?= date('d/m/Y', strtotime($ev['tanggal'])); ?></small>
                                    </td>
                                    <td><span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill"><?= $ev['kategori']; ?></span></td>
                                    <td>
                                        <?php if($ev['kuota'] > 0): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill"><?= $ev['kuota']; ?> Slot</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Penuh</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="auth/hapus_event.php?id=<?= $ev['id']; ?>" class="btn btn-outline-danger btn-sm rounded-circle" onclick="return confirm('Hapus event ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahEvent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="auth/tambah_event.php" method="POST">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="modal-title fw-bold">Input Event Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Nama Event</label>
                        <input type="text" name="nama_event" class="form-control rounded-3" placeholder="Contoh: IT Conference" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase">Kategori</label>
                        <select name="kategori" class="form-select rounded-3">
                            <option value="Seminar">Seminar</option>
                            <option value="Workshop">Workshop</option>
                            <option value="Lomba">Lomba</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold text-uppercase">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control rounded-3" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold text-uppercase">Kuota</label>
                            <input type="number" name="kuota" class="form-control rounded-3" placeholder="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" name="simpan_event" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Terbitkan Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>