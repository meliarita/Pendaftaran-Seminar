<?php
session_start();
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM events WHERE id = $id");
    header("Location: ../admin_dashboard.php");
}
?>