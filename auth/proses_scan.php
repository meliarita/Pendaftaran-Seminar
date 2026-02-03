<?php
session_start();
// Menghubungkan ke database. ../ karena db.php berada di luar folder auth
include '../config/db.php';

// Pastikan hanya admin yang bisa memproses scan
if (!isset($_SESSION['admin_login'])) {
    header("Location: ../admin_login.php");
    exit;
}

if (isset($_POST['kode_tiket'])) {
    // Ambil kode tiket dan bersihkan dari karakter berbahaya
    $kode_tiket = mysqli_real_escape_string($conn, $_POST['kode_tiket']);

    // 1. Cek apakah kode tiket tersebut ada di database
    $cek_tiket = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE kode_tiket = '$kode_tiket'");
    
    if (mysqli_num_rows($cek_tiket) > 0) {
        $data = mysqli_fetch_assoc($cek_tiket);
        
        // 2. Cek jika statusnya sudah "Hadir" sebelumnya
        if ($data['status_kehadiran'] == 'Hadir') {
            echo "<script>
                    alert('Gagal! Peserta dengan kode $kode_tiket sudah melakukan absen sebelumnya.');
                    window.location='../admin_scan.php';
                  </script>";
        } else {
            // 3. Update status menjadi Hadir
            $update = mysqli_query($conn, "UPDATE pendaftaran SET status_kehadiran = 'Hadir' WHERE kode_tiket = '$kode_tiket'");
            
            if ($update) {
                echo "<script>
                        alert('BERHASIL! Kehadiran peserta telah dikonfirmasi. Sertifikat sekarang tersedia untuk mereka.');
                        window.location='../admin_scan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Terjadi kesalahan sistem saat memperbarui data.');
                        window.location='../admin_scan.php';
                      </script>";
            }
        }
    } else {
        // Jika kode tiket tidak ditemukan
        echo "<script>
                alert('TIDAK VALID! Kode tiket tidak ditemukan dalam sistem kami.');
                window.location='../admin_scan.php';
              </script>";
    }
} else {
    // Jika mencoba akses file langsung tanpa form
    header("Location: ../admin_scan.php");
    exit;
}
?>