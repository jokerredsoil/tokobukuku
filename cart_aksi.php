<?php
require 'data/connection.php';
session_start();

// Proteksi: Kalau belum login, lempar ke halaman login
if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    header("location:index.php");
    exit();
}
$id_user = isset($_SESSION['id']) ? $_SESSION['id'] : 0;

// 1. AKSI TAMBAH KE KERANJANG
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id_buku = $_GET['id_buku'];
    $jumlah = 1; // Default tambah 1 item

    // Cek dulu apakah buku ini udah ada di cart user tersebut
    $cek_cart = mysqli_query($connection, "SELECT * FROM cart WHERE id_user = $id_user AND id_buku = $id_buku");

    if (mysqli_num_rows($cek_cart) > 0) {
        // Kalau udah ada, tinggal update jumlahnya (ditambah 1)
        $row_cart = mysqli_fetch_assoc($cek_cart);
        $jumlah_baru = $row_cart['jumlah'] + 1;
        
        $query = "UPDATE cart SET jumlah = '$jumlah_baru' WHERE id_user = $id_user AND id_buku = $id_buku";
    } else {
        // Kalau belum ada, insert data baru
        $query = "INSERT INTO cart (id_user, id_buku, jumlah) VALUES ($id_user, $id_buku, '$jumlah')";
    }

    mysqli_query($connection, $query);
    header("location:cart.php");
    exit();
}

// 2. AKSI HAPUS DARI KERANJANG
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id_buku = $_GET['id_buku'];

    $query = "DELETE FROM cart WHERE id_user = $id_user AND id_buku = $id_buku";
    mysqli_query($connection, $query);
    
    header("location:cart.php");
    exit();
}
?>