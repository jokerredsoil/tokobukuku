<?php include("template/header.php"); ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1>List Buku</h1>
            <h5 class="text-muted">Selamat datang, <?= $_SESSION['nama'] ?>! <span class="badge bg-secondary"><?= $_SESSION['role'] ?></span></h5>
        </div>


        <?php if ($_SESSION['role'] == 'Admin') : ?>
            <a href="buku_create.php" class="btn btn-primary fw-semibold">
                <i class="bi bi-plus-circle"></i> Tambah Buku Baru
            </a>
        <?php else : ?>
            <a href="cart.php" class="btn btn-outline-success fw-semibold">
                Lihat Keranjang
            </a>
        <?php endif; ?>


    </div>
    <!-- UI search -->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <form class="d-flex" role="search" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search" />
                <button name="submit" class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>
<!-- UI search end -->
    <div class="row">
        <?php
        // logic search
        if (!isset($_POST['search']) || empty($_POST['search'])) {
            // Query ambil data buku digabung dengan nama kategorinya
            $query = "SELECT buku.*, kategori_buku.nama AS nama_kategori 
                  FROM buku 
                  LEFT JOIN kategori_buku ON buku.id_kategori_buku = kategori_buku.id 
                  ORDER BY buku.id DESC";
        } else {
            // Query ambil data buku digabung dengan nama kategorinya
            $query = "SELECT buku.*, kategori_buku.nama AS nama_kategori 
                  FROM buku 
                  LEFT JOIN kategori_buku ON buku.id_kategori_buku = kategori_buku.id 
                  WHERE buku.judul_buku LIKE '%" . $_POST['search'] . "%' ORDER BY buku.id DESC";
        }
            // logic search end
        $data = mysqli_query($connection, $query);

        if (mysqli_num_rows($data) > 0) {
            while ($data_row = mysqli_fetch_assoc($data)) {
        ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="img/<?= $data_row['gambar'] ?>" class="card-img-top" alt="Cover Buku" style="height: 250px; object-fit: cover;">

                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-info text-white mb-2 align-self-start"><?= $data_row['nama_kategori'] ?? 'Tanpa Kategori' ?></span>
                            <h5 class="card-title fw-bold text-dark text-truncate" title="<?= $data_row['judul_buku'] ?>"><?= $data_row['judul_buku'] ?></h5>
                            <p class="card-text text-muted small mb-1">Pengarang: <?= $data_row['pengarang'] ?></p>
                            <p class="card-text text-muted small mb-3">Penerbit: <?= $data_row['penerbit'] ?> (<?= $data_row['tahun_terbit'] ?>)</p>

                            <div class="mt-auto">
                                <h6 class="fw-bold text-primary fs-5 mb-3">Rp <?= number_format($data_row['harga'], 0, ',', '.') ?></h6>

                                <?php if ($_SESSION['role'] == 'Admin') : ?>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                        <a href="buku_update.php?id=<?= $data_row['id'] ?>" class="btn btn-sm btn-warning text-white flex-grow-1">Ubah</a>
                                        <a href="buku_delete.php?id=<?= $data_row['id'] ?>" class="btn btn-sm btn-danger flex-grow-1" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                                    </div>
                                <?php else : ?>
                                    <div class="d-grid">
                                        <a href="cart_aksi.php?action=add&id_buku=<?= $data_row['id'] ?>" class="btn btn-success fw-semibold">
                                            Tambah ke Keranjang
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="col-12">
                <div class="alert alert-light text-center py-5 border" role="alert">
                    <h4 class="text-muted">Belum ada koleksi buku nih.</h4>
                    <?php if ($_SESSION['role'] == 'Admin') : ?>
                        <p class="text-muted small">Silahkan klik tombol Tambah Buku di atas untuk mengisinya.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php include("template/footer.php"); ?>