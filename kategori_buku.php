
<?php include("template/header.php"); ?>
<div class="container">
    <h1>List User</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Kategori</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $x=1;
                $query = "SELECT * FROM kategori_buku";
                $data = mysqli_query($connection, $query);
                while($data_row = mysqli_fetch_assoc($data)){
                    ?>
                        <tr>
                            <th scope="row"><?=$x?></th>
                            <td><?=$data_row['nama']?></td>
                            <td>
                                <a href="kategori_buku_update.php?id=<?=$data_row['id']?>">Ubah</a>
                                <a href="kategori_buku_delete.php?id=<?=$data_row['id']?>">Hapus</a>
                            </td>
                        </tr>
                    <?php
                    $x++;
                }
            ?>
        </tbody>
    </table>
    <a href="kategori_buku_create.php">
        <button type="button" class="btn btn-primary">Tambah Data</button>
    </a>
</div>
<?php include("template/footer.php"); ?>