<?php
require 'data/connection.php';
session_start();

// Proteksi halaman: Hanya Admin yang boleh masuk
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'Admin') {
    header("location:index.php");
    exit();
}

$id = $_GET['id'];

// Logika update status pesanan ketika tombol disubmit
if (isset($_POST['submit'])) {
    extract($_POST);
    
    $query_update = "UPDATE pesanan SET status = '$status' WHERE id = $id";
    mysqli_query($connection, $query_update);
    
    header("location:list_pesanan.php");
    exit();
}

// Ambil data lama untuk ditampilkan di form select
$query_pesanan = mysqli_query($connection, "SELECT pesanan.*, user.nama FROM pesanan JOIN user ON pesanan.id_user = user.id WHERE pesanan.id = $id");
$pesanan = mysqli_fetch_assoc($query_pesanan);

include("template/header.php");
?>

<div class="container mt-4">
    <div class="card shadow-sm border-0 p-4" style="max-width: 500px; margin: 0 auto;">
        <h3 class="mb-3 fw-bold text-primary">Ubah Status Pesanan</h3>
        <p class="text-muted">ID Pesanan: <strong>#PSN-<?=$pesanan['id']?></strong><br>Nama Pembeli: <?=$pesanan['nama']?></p>
        <hr>
        
        <form action="<?=$_SERVER['PHP_SELF']?>?id=<?=$id?>" method="post">
            <div class="mb-4">
                <label for="status" class="form-label fw-semibold">Status Transaksi</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Konfirmasi Pembayaran" <?=($pesanan['status'] == 'Konfirmasi Pembayaran') ? 'selected' : ''?>>Konfirmasi Pembayaran</option>
                    <option value="Pengiriman" <?=($pesanan['status'] == 'Pengiriman') ? 'selected' : ''?>>Pengiriman</option>
                    <option value="Selesai" <?=($pesanan['status'] == 'Selesai') ? 'selected' : ''?>>Selesai</option>
                </select>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" name="submit" class="btn btn-primary px-4 fw-semibold">Simpan Perubahan</button>
                <a href="list_pesanan.php" class="btn btn-secondary px-4">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?php include("template/footer.php"); ?>