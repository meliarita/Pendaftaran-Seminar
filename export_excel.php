<?php
include 'config/db.php';

// Memberi tahu browser bahwa ini adalah file Excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Peserta_Event.xls");

?>

<h2>Laporan Pendaftaran Event Kampus</h2>

<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Peserta</th>
            <th>Nama Event</th>
            <th>Kategori</th>
            <th>Kode Tiket</th>
            <th>Tanggal Daftar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $query = "SELECT p.*, u.username, e.nama_event, e.kategori 
                  FROM pendaftaran p
                  JOIN users u ON p.user_id = u.id
                  JOIN events e ON p.event_id = e.id
                  ORDER BY p.tgl_daftar DESC";
        $result = mysqli_query($conn, $query);
        
        while($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['username']; ?></td>
            <td><?= $row['nama_event']; ?></td>
            <td><?= $row['kategori']; ?></td>
            <td><?= $row['kode_tiket']; ?></td>
            <td><?= $row['tgl_daftar']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>