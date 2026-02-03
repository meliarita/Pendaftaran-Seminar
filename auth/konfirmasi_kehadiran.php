<?php
include '../config/db.php';
$id = $_GET['id'];
$update = mysqli_query($conn, "UPDATE pendaftaran SET status_kehadiran = 'Hadir' WHERE id = '$id'");
if ($update) {
    echo "<script>alert('Kehadiran berhasil dikonfirmasi!'); window.history.back();</script>";
}
?>