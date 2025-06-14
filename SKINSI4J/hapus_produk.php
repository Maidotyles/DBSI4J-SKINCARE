<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Cek apakah ID produk ada
    $cek = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$id'");
    if (mysqli_num_rows($cek) > 0) {
        // Lanjut hapus
        $hapus = mysqli_query($conn, "DELETE FROM produk WHERE id = '$id'");

        if ($hapus) {
            echo "<script>alert('Produk berhasil dihapus.'); window.location='produk.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus produk.'); window.location='produk.php';</script>";
        }
    } else {
        echo "<script>alert('Produk tidak ditemukan.'); window.location='produk.php';</script>";
    }
} else {
    echo "<script>alert('ID produk tidak valid.'); window.location='produk.php';</script>";
}
?>
