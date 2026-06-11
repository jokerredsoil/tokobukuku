<?php
require 'data/connection.php';
session_start();

// Proteksi: Jika belum login atau session ID tidak ada, tendang ke login
if (!isset($_SESSION['login']) || !$_SESSION['login'] || !isset($_SESSION['id'])) {
    header("location:index.php");
    exit();
}

$id_user = $_SESSION['id'];

// Cek apakah keranjang belanja user kosong atau tidak sebelum diproses
$cek_cart = mysqli_query($connection, "SELECT * FROM cart WHERE id_user = $id_user");

if (mysqli_num_rows($cek_cart) > 0) {
    
    // 1. Insert data utama ke tabel induk `pesanan`
    // Sesuai isi enum di database lo, status default-nya adalah 'Konfirmasi Pembayaran'
    $query_pesanan = "INSERT INTO pesanan (id_user, status, tanggal) VALUES ($id_user, 'Konfirmasi Pembayaran', NOW())";
    mysqli_query($connection, $query_pesanan);
    
    // Ambil ID pesanan yang baru saja di-generate oleh database otomatis
    $id_pesanan_baru = mysqli_insert_id($connection);

    // 2. Ambil semua item buku yang ada di cart milik user saat ini
    $cart_data = mysqli_query($connection, "SELECT cart.*, buku.harga FROM cart JOIN buku ON cart.id_buku = buku.id WHERE cart.id_user = $id_user");

    // 3. Looping untuk memindahkan data satu per satu ke tabel `detail_pesanan`
    while ($cart_row = mysqli_fetch_assoc($cart_data)) {
        $id_buku = $cart_row['id_buku'];
        $jumlah = $cart_row['jumlah'];
        $harga_satuan = $cart_row['harga'];

        $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_buku, jumlah, harga_satuan) 
                         VALUES ($id_pesanan_baru, $id_buku, '$jumlah', '$harga_satuan')";
        mysqli_query($connection, $query_detail);
    }

    // 4. Bersihkan/kosongkan tabel cart milik user karena transaksi sudah berhasil dibuat
    mysqli_query($connection, "DELETE FROM cart WHERE id_user = $id_user");

    // 5. Alihkan halaman langsung ke list_pesanan.php untuk melihat hasilnya
    header("location:list_pesanan.php");
    exit();

} else {
    // Kalau iseng nembak URL padahal cart kosong, balikin ke halaman listbuku
    header("location:listbuku.php");
    exit();
}
?>