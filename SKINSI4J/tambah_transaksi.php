<?php
include 'koneksi.php';
include 'partials/header.php';
include 'partials/sidebar.php';

// Simpan transaksi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_pelanggan = $_POST['id_pelanggan'];
  $tanggal = date('Y-m-d H:i:s');
  $total = 0;

  // Hitung total dari produk
  foreach ($_POST['produk'] as $id_produk => $jumlah) {
    if ($jumlah > 0) {
      $query = mysqli_query($conn, "SELECT harga FROM produk WHERE id = $id_produk");
      $produk = mysqli_fetch_assoc($query);
      $subtotal = $produk['harga'] * $jumlah;
      $total += $subtotal;
    }
  }

  // Simpan ke tabel transaksi
  mysqli_query($conn, "INSERT INTO transaksi (tanggal, total, id_pelanggan) VALUES ('$tanggal', $total, $id_pelanggan)");
  $id_transaksi = mysqli_insert_id($conn);

  // Simpan ke transaksi_detail
  foreach ($_POST['produk'] as $id_produk => $jumlah) {
    if ($jumlah > 0) {
      $query = mysqli_query($conn, "SELECT harga FROM produk WHERE id = $id_produk");
      $produk = mysqli_fetch_assoc($query);
      $harga = $produk['harga'];
      $subtotal = $harga * $jumlah;

      mysqli_query($conn, "INSERT INTO transaksi_detail (id_transaksi, id_produk, jumlah, harga_satuan, subtotal) 
                           VALUES ($id_transaksi, $id_produk, $jumlah, $harga, $subtotal)");

      // Kurangi stok
      mysqli_query($conn, "UPDATE produk SET stok = stok - $jumlah WHERE id = $id_produk");
    }
  }

  echo "<script>alert('Transaksi berhasil disimpan!'); location.href='transaksi.php';</script>";
  exit;
}

// Ambil data pelanggan dan produk
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
$produk = mysqli_query($conn, "SELECT * FROM produk WHERE stok > 0");
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
  <h4 class="mt-4 mb-4"><i class="fas fa-cart-plus"></i> Tambah Transaksi</h4>
  <form method="post">
    <div class="form-group">
      <label for="id_pelanggan">Pelanggan</label>
      <select name="id_pelanggan" class="form-control" required>
        <option value="0">Umum</option>
        <?php while ($row = mysqli_fetch_assoc($pelanggan)) : ?>
          <option value="<?= $row['id'] ?>"><?= $row['nama'] ?> - <?= $row['kontak'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <h5 class="mt-4">Produk yang Dibeli</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Jumlah</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($p = mysqli_fetch_assoc($produk)) : ?>
          <tr>
            <td><?= $p['nama_produk'] ?></td>
            <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
            <td><?= $p['stok'] ?></td>
            <td>
              <input type="number" name="produk[<?= $p['id'] ?>]" class="form-control" min="0" max="<?= $p['stok'] ?>" value="0">
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <button type="submit" class="btn btn-primary">
      <i class="fas fa-save"></i> Simpan Transaksi
    </button>
    <a href="transaksi.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>