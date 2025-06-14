<?php
include 'koneksi.php';


// Ambil filter tanggal jika ada
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Ambil data transaksi pada tanggal tersebut
$query = "SELECT t.*, p.nama AS nama_pelanggan 
          FROM transaksi t 
          LEFT JOIN pelanggan p ON t.id_pelanggan = p.id
          WHERE DATE(t.tanggal) = '$tanggal'
          ORDER BY t.tanggal DESC";

$result = mysqli_query($conn, $query);
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
<?php include 'partials/header.php';
include 'partials/navbar.php';
include 'partials/sidebar.php';?>
<div class="container"><br><br><br>
<div class="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-file-alt"></i> Laporan Transaksi Harian</h4>
    <form method="get" class="form-inline">
  <input type="date" name="tanggal" class="form-control mr-2" value="<?= $tanggal ?>">
  <button type="submit" class="btn btn-primary mr-2">
    <i class="fas fa-search"></i> Tampilkan
  </button>
  <button type="button" class="btn btn-secondary" onclick="window.print()">
    <i class="fas fa-print"></i> Cetak
  </button>
</form>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="thead-dark">
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>Pelanggan</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $grand_total = 0;
        while ($row = mysqli_fetch_assoc($result)) {
          $grand_total += $row['total'];
        ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?></td>
            <td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
            <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="text-right">Total Omset:</th>
          <th>Rp <?= number_format($grand_total, 0, ',', '.') ?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>