<?php
include 'koneksi.php';


// Ambil data transaksi + nama pelanggan
$query = "SELECT transaksi.*, pelanggan.nama AS nama_pelanggan 
          FROM transaksi 
          LEFT JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id
          ORDER BY transaksi.tanggal DESC";
$result = mysqli_query($conn, $query);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

<?php 
include 'partials/header.php';
include 'partials/navbar.php';
include 'partials/sidebar.php';?>
<div class="container"><br><br><br>
  <h4 class="mt-4 mb-4"><i class="fas fa-exchange-alt"></i> Data Transaksi</h4>
  <a href="tambah_transaksi.php" class="btn btn-success mb-3">
    <i class="fas fa-plus-circle"></i> Tambah Transaksi
  </a>

  <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
     
      <thead class="thead-dark">
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>Pelanggan</th>
          <th>Total</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])); ?></td>
          <td><?= $row['nama_pelanggan'] ?: '<i>Umum</i>'; ?></td>
          <td>Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
          <td>
            <!-- Tombol aksi (Edit/Delete bisa disesuaikan jika dibutuhkan) -->
            <a href="hapus_transaksi.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" 
               onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
              <i class="fas fa-trash"></i>
            </a>
            
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>