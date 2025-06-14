<?php
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

// Cek apakah ID valid
if ($id > 0) {
  // Hapus dari transaksi_detail
  mysqli_query($conn, "DELETE FROM transaksi_detail WHERE id_transaksi = $id");

  // Hapus dari transaksi
  mysqli_query($conn, "DELETE FROM transaksi WHERE id = $id");

  echo "<script>alert('Transaksi berhasil dihapus.'); window.location.href='transaksi.php';</script>";
} else {
  echo "<script>alert('ID transaksi tidak ditemukan!'); window.location.href='transaksi.php';</script>";
}
