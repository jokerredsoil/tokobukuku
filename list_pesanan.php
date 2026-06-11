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
                
                // Filter query berdasarkan role
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
                        $id_pesanan = $data_row['id'];
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
                                <td><strong>#PSN-<?=$id_pesanan?></strong></td>
                                <td><?=$data_row['nama_pembeli']?></td>
                                <td><?=date('d M Y H:i', strtotime($data_row['tanggal']))?></td>
                                <td><?=$data_row['total_item'] ?? 0?> Buku</td>
                                <td>Rp <?=number_format($data_row['total_bayar'] ?? 0, 0, ',', '.')?></td>
                                <td>
                                    <span class="badge <?=$badge_color?>"><?=$status?></span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#detail-<?=$id_pesanan?>">
                                        Detail
                                    </button>
                                    
                                    <?php if ($_SESSION['role'] == 'Admin') : ?>
                                        <a href="pesanan_update.php?id=<?=$id_pesanan?>" class="btn btn-sm btn-warning text-white">Edit</a>
                                    <?php endif; ?>
                                    
                                    <a href="pesanan_delete.php?id=<?=$id_pesanan?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data pesanan ini?')">Hapus</a>
                                </td>
                            </tr>

                            <tr class="collapse bg-light" id="detail-<?=$id_pesanan?>">
                                <td colspan="8" class="p-3">
                                    <div class="card card-body border-0 shadow-sm">
                                        <h6 class="fw-bold text-secondary mb-2">Rincian Item Buku (#PSN-<?=$id_pesanan?>):</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered m-0 bg-white">
                                                <thead class="table-dark small">
                                                    <tr>
                                                        <th>Judul Buku</th>
                                                        <th>Harga Satuan</th>
                                                        <th class="text-center">Jumlah</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="small">
                                                    <?php
                                                    // Query ambil item buku di dalam pesanan ini
                                                    $detail_query = mysqli_query($connection, "SELECT detail_pesanan.*, buku.judul_buku 
                                                                                               FROM detail_pesanan 
                                                                                               JOIN buku ON detail_pesanan.id_buku = buku.id 
                                                                                               WHERE detail_pesanan.id_pesanan = $id_pesanan");
                                                    
                                                    while ($detail_row = mysqli_fetch_assoc($detail_query)) {
                                                        $subtotal_item = $detail_row['harga_satuan'] * $detail_row['jumlah'];
                                                        ?>
                                                        <tr>
                                                            <td><?=$detail_row['judul_buku']?></td>
                                                            <td>Rp <?=number_format($detail_row['harga_satuan'], 0, ',', '.')?></td>
                                                            <td class="text-center"><?=$detail_row['jumlah']?></td>
                                                            <td class="fw-semibold text-primary">Rp <?=number_format($subtotal_item, 0, ',', '.')?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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