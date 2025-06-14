<?php
include 'koneksi.php';


// Query untuk ambil data detail transaksi lengkap
$query = "
  SELECT dt.*, 
         p.nama_produk, 
         t.tanggal, 
         pl.nama AS nama_pelanggan
  FROM detail_transaksi dt
  JOIN produk p ON dt.id_produk = p.id
  JOIN transaksi t ON dt.id_transaksi = t.id
  JOIN pelanggan pl ON t.id_pelanggan = pl.id
  ORDER BY t.tanggal DESC
";

$result = mysqli_query($conn, $query);
?>
<?php include 'partials/header.php';
include 'partials/navbar.php';
include 'partials/sidebar.php';?>
<div class="content">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><i class="fas fa-receipt"></i> Detail Transaksi</h4>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover table-striped">
      <thead class="thead-dark">
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>Pelanggan</th>
          <th>Produk</th>
          <th>Harga Satuan</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= date('d-m-Y H:i', strtotime($row['tanggal'])) ?></td>
            <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
            <td>Rp <?= number_format($row['harga_satuan'], 0, ',', '.') ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td>Rp <?= number_format($row['subtotal'], 0, ',', '.') ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<a href="detail_transaksi.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
  <i class="fas fa-eye"></i>
<?php include 'partials/footer.php'; ?>
