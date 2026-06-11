<?php
require 'template/header.php';
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">List Pesanan</h1>
        
        <?php if ($_SESSION['role'] == 'User') : ?>
            <a href="cart.php" class="btn btn-success fw-semibold">
                <i class="bi bi-plus-circle"></i> Tambah Pesanan Baru
            </a>
        <?php endif; ?>
    </div>
    
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Pesanan</th>
                <th scope="col">Nama Pembeli</th>
                <th scope="col">Tanggal Pesanan</th>
                <th scope="col">Total Item</th>
                <th scope="col">Total Bayar</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $x = 1;
                $id_user = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
                // Jika role-nya User, dia hanya bisa melihat pesanannya sendiri
                $id_user = $_SESSION['id'];
                if ($_SESSION['role'] == 'User') {
                    $query = "SELECT pesanan.*, user.nama AS nama_pembeli, 
                                     SUM(detail_pesanan.jumlah) AS total_item,
                                     SUM(detail_pesanan.jumlah * detail_pesanan.harga_satuan) AS total_bayar
                              FROM pesanan 
                              JOIN user ON pesanan.id_user = user.id 
                              LEFT JOIN detail_pesanan ON pesanan.id = detail_pesanan.id_pesanan
                              WHERE pesanan.id_user = $id_user
                              GROUP BY pesanan.id
                              ORDER BY pesanan.tanggal DESC";
                } else {
                    // Jika Admin, bisa melihat semua pesanan yang masuk
                    $query = "SELECT pesanan.*, user.nama AS nama_pembeli, 
                                     SUM(detail_pesanan.jumlah) AS total_item,
                                     SUM(detail_pesanan.jumlah * detail_pesanan.harga_satuan) AS total_bayar
                              FROM pesanan 
                              JOIN user ON pesanan.id_user = user.id 
                              LEFT JOIN detail_pesanan ON pesanan.id = detail_pesanan.id_pesanan
                              GROUP BY pesanan.id
                              ORDER BY pesanan.tanggal DESC";
                }
                          
                $data = mysqli_query($connection, $query);
                
                if (mysqli_num_rows($data) > 0) {
                    while($data_row = mysqli_fetch_assoc($data)){
                        $status = $data_row['status'];
                        $badge_color = 'bg-warning text-dark'; 
                        
                        if ($status == 'Pengiriman') {
                            $badge_color = 'bg-info text-white';
                        } elseif ($status == 'Selesai') {
                            $badge_color = 'bg-success text-white';
                        }
                        ?>
                            <tr>
                                <th scope="row"><?=$x?></th>
                                <td><strong>#PSN-<?=$data_row['id']?></strong></td>
                                <td><?=$data_row['nama_pembeli']?></td>
                                <td><?=date('d M Y H:i', strtotime($data_row['tanggal']))?></td>
                                <td><?=$data_row['total_item'] ?? 0?> Buku</td>
                                <td>Rp <?=number_format($data_row['total_bayar'] ?? 0, 0, ',', '.')?></td>
                                <td>
                                    <span class="badge <?=$badge_color?>"><?=$status?></span>
                                </td>
                                <td>
                                    <a href="pesanan_detail.php?id=<?=$data_row['id']?>" class="btn btn-sm btn-primary">Detail</a>
                                    
                                    <?php if ($_SESSION['role'] == 'Admin') : ?>
                                        <a href="pesanan_update.php?id=<?=$data_row['id']?>" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <?php endif; ?>
                                    
                                    <a href="pesanan_delete.php?id=<?=$data_row['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data pesanan ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php
                        $x++;
                    }
                } else {
                    ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada pesanan yang masuk.</td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
</div>

<?php
require 'template/footer.php';
?>