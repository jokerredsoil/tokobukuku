<?php 
include("template/header.php"); 

// Proteksi halaman keranjang
if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    header("location:index.php");
    exit();
}

// AMANKAN DI SINI: Kalau $_SESSION['id'] belum ke-set, isi pake 0 biar query ga jebol
$id_user = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
?>

<div class="container">
    <h1 class="mb-4">Keranjang Belanja Anda</h1>
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Gambar</th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Harga</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $x = 1;
                $total_belanja = 0;

                // Query join tabel cart dengan tabel buku berdasarkan user yang login
                $query = "SELECT cart.*, buku.judul_buku, buku.harga, buku.gambar 
                          FROM cart 
                          JOIN buku ON cart.id_buku = buku.id 
                          WHERE cart.id_user = $id_user";
                          
                $data = mysqli_query($connection, $query);

                if (mysqli_num_rows($data) > 0) {
                    while($data_row = mysqli_fetch_assoc($data)){
                        $subtotal = $data_row['harga'] * $data_row['jumlah'];
                        $total_belanja += $subtotal;
                        ?>
                            <tr>
                                <th scope="row"><?=$x?></th>
                                <td>
                                    <img src="img/<?=$data_row['gambar']?>" alt="Cover" style="width: 60px; height: auto;" class="img-thumbnail">
                                </td>
                                <td><strong><?=$data_row['judul_buku']?></strong></td>
                                <td>Rp <?=number_format($data_row['harga'], 0, ',', '.')?></td>
                                <td><?=$data_row['jumlah']?></td>
                                <td>Rp <?=number_format($subtotal, 0, ',', '.')?></td>
                                <td>
                                    <a href="cart_aksi.php?action=delete&id_buku=<?=$data_row['id_buku']?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus buku ini dari keranjang?')">Hapus</a>
                                </td>
                            </tr>
                        <?php
                        $x++;
                    }
                    ?>
                        <tr class="table-light fw-bold">
                            <td colspan="5" class="text-end">Total Yang Harus Dibayar :</td>
                            <td colspan="2">Rp <?=number_format($total_belanja, 0, ',', '.')?></td>
                        </tr>
                    <?php
                } else {
                    ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Keranjang belanja lo masih kosong nih. Yuk hunting buku dulu!</td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-between mt-4">
        <a href="listbuku.php" class="btn btn-outline-secondary">Kembali Belanja</a>
        <?php if (mysqli_num_rows($data) > 0) : ?>
            <a href="checkout_aksi.php" class="btn btn-success fw-semibold">Checkout (Buat Pesanan)</a>
        <?php endif; ?>
    </div>
</div>

<?php include("template/footer.php"); ?>