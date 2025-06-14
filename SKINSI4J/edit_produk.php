<?php
include 'koneksi.php';


// Ambil ID produk dari URL
$id = $_GET['id'];

// Cek apakah produk ada
$produk = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$id'");
$data = mysqli_fetch_assoc($produk);

// Ambil semua kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori");

// Jika form disubmit
if (isset($_POST['update'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $id_kat = $_POST['id_kategori'];
    $harga  = $_POST['harga'];
    $stok   = $_POST['stok'];

    $update = mysqli_query($conn, "UPDATE produk SET 
                nama_produk = '$nama',
                id_kategori = '$id_kat',
                harga = '$harga',
                stok = '$stok'
              WHERE id = '$id'");

    if ($update) {
        echo "<script>alert('Data produk berhasil diperbarui!'); location.href='produk.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui produk.</div>";
    }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <?php include 'partials/header.php';?>
<?php include 'partials/navbar.php';?>
<?php include 'partials/sidebar.php';?>

<div class="container">
    <br><br><br>
  <h4><i class="fas fa-edit"></i> Edit Produk</h4>

  <form method="POST">
    <div class="form-group">
      <label>Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($data['nama_produk']) ?>" required>
    </div>

    <div class="form-group">
      <label>Kategori</label>
      <select name="id_kategori" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        <?php while($row = mysqli_fetch_assoc($kategori)) { ?>
          <option value="<?= $row['id'] ?>" <?= $row['id'] == $data['id_kategori'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($row['nama_kategori']) ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <div class="form-group">
      <label>Harga</label>
      <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
    </div>

    <div class="form-group">
      <label>Stok</label>
      <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
    </div>

    <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
    <a href="produk.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>

