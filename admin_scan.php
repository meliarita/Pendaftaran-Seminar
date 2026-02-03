<?php 
session_start();
include 'config/db.php';

// Proteksi Admin: Pastikan hanya admin yang bisa akses
if (!isset($_SESSION['admin_login'])) {
    header("Location: admin_login.php");
    exit;
}

include 'layout/header.php'; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-qr-code-scan me-2"></i> SCANNER KEHADIRAN</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="text-muted">Arahkan kamera ke QR Code tiket peserta untuk konfirmasi kehadiran.</p>
                    
                    <div id="reader" class="rounded-3 overflow-hidden bg-light" style="width: 100%;"></div>

                    <div id="result-box" class="mt-4 d-none">
                        <div class="alert alert-info border-0 shadow-sm rounded-4 p-4">
                            <i class="bi bi-ticket-detailed fs-1 text-primary d-block mb-2"></i>
                            <h6 class="text-uppercase fw-bold text-muted small mb-1">Tiket Terdeteksi</h6>
                            <h4 id="scanned-code" class="fw-bold text-dark mb-3"></h4>
                            
                            <form action="auth/proses_scan.php" method="POST">
                                <input type="hidden" name="kode_tiket" id="input-kode">
                                <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2 shadow">
                                    Konfirmasi & Update Status
                                </button>
                            </form>
                            <button onclick="location.reload()" class="btn btn-link text-decoration-none text-muted mt-2 small">
                                <i class="bi bi-arrow-clockwise"></i> Scan Ulang
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-center pb-4">
                    <a href="admin_dashboard.php" class="btn btn-outline-secondary rounded-pill px-4 btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fungsi yang berjalan saat QR Code berhasil dibaca
function onScanSuccess(decodedText, decodedResult) {
    // Berhenti memindai agar tidak terjadi pengiriman data ganda
    html5QrcodeScanner.clear();
    
    // Tampilkan elemen hasil scan
    document.getElementById('result-box').classList.remove('d-none');
    document.getElementById('scanned-code').innerText = decodedText;
    document.getElementById('input-kode').value = decodedText;

    // Putar suara beep (opsional)
    let audio = new Audio('https://www.soundjay.com/buttons/beep-07a.mp3');
    audio.play();
}

// Inisialisasi library Html5QrcodeScanner
let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader", { 
        fps: 10, 
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0 
    }
);

html5QrcodeScanner.render(onScanSuccess);
</script>

<?php include 'layout/footer.php'; ?>