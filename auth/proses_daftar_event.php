<?php
session_start();
include '../config/db.php';

if (isset($_POST['daftar'])) {
    $event_id = $_POST['event_id'];
    $username = $_SESSION['user'];

    // 1. Ambil ID user
    $user_query = mysqli_query($conn, "SELECT id FROM users WHERE username = '$username'");
    $user_data = mysqli_fetch_assoc($user_query);
    $user_id = $user_data['id'];

    // 2. Cek apakah kuota masih tersedia di database
    $event_query = mysqli_query($conn, "SELECT kuota FROM events WHERE id = '$event_id'");
    $event_data = mysqli_fetch_assoc($event_query);
    $kuota_sekarang = $event_data['kuota'];

    if ($kuota_sekarang <= 0) {
        echo "<script>alert('Maaf, kuota baru saja penuh!'); window.location='../daftar_event.php';</script>";
        exit;
    }

    // 3. Cek apakah user sudah pernah daftar (agar tidak double)
    $cek_daftar = mysqli_query($conn, "SELECT * FROM pendaftaran WHERE user_id = '$user_id' AND event_id = '$event_id'");
    
    if (mysqli_num_rows($cek_daftar) > 0) {
        echo "<script>alert('Anda sudah terdaftar di event ini!'); window.location='../daftar_event.php';</script>";
    } else {
        // 4. Mulai proses pendaftaran (Gunakan Transaction jika perlu, tapi ini cara simpelnya)
        $kode_tiket = "EVT-" . date('Y') . "-" . strtoupper(substr(md5(time()), 0, 5));
        
        // Simpan ke tabel pendaftaran
        $insert = mysqli_query($conn, "INSERT INTO pendaftaran (user_id, event_id, kode_tiket) VALUES ('$user_id', '$event_id', '$kode_tiket')");

        if ($insert) {
            // 5. KURANGI KUOTA DI TABEL EVENTS
            mysqli_query($conn, "UPDATE events SET kuota = kuota - 1 WHERE id = '$event_id'");
            
            echo "<script>alert('Pendaftaran Berhasil! Kuota telah dikurangi.'); window.location='../tiket_saya.php';</script>";
        }
    }
}
?>