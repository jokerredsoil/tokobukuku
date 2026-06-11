<?php
include("template/header.php");

// Proteksi: Hanya Admin
if ($_SESSION['role'] != 'Admin') {
    header("location:listbuku.php");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM `buku` WHERE id = $id"; 
$data = mysqli_query($connection, $query);
$data_row = mysqli_fetch_assoc($data);
?>

<div class="container mt-4">
    <h1>Ubah Data Buku</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>?id=<?=$id?>" method="post" enctype="multipart/form-data" class="mt-4">
        <input type="hidden" name="id" value="<?=$id?>">
        
        <div class="mb-3">
            <label for="judul_buku" class="form-label">Judul Buku</label>
            <input type="text" name="judul_buku" class="form-control" id="judul_buku" value="<?=$data_row['judul_buku']?>" required>
        </div>

        <div class="mb-3">
            <label for="id_kategori_buku" class="form-label">Kategori Buku</label>
            <select name="id_kategori_buku" class="form-select" id="id_kategori_buku" required>
                <?php
                $kat_query = mysqli_query($connection, "SELECT * FROM kategori_buku");
                while($kat = mysqli_fetch_assoc($kat_query)) {
                    $selected = ($kat['id'] == $data_row['id_kategori_buku']) ? 'selected' : '';
                    echo "<option value='".$kat['id']."' $selected>".$kat['nama']."</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="pengarang" class="form-label">Pengarang</label>
            <input type="text" name="pengarang" class="form-control" id="pengarang" value="<?=$data_row['pengarang']?>" required>
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" name="penerbit" class="form-control" id="penerbit" value="<?=$data_row['penerbit']?>" required>
        </div>

        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="text" name="tahun_terbit" class="form-control" id="tahun_terbit" value="<?=$data_row['tahun_terbit']?>" maxlength="4" required>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" id="harga" value="<?=$data_row['harga']?>" required>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Ganti Cover Buku (Biarkan kosong jika tidak ingin diubah)</label>
            <input type="file" name="gambar" class="form-control" id="gambar">
            <small class="text-muted">File saat ini: <?=$data_row['gambar']?></small>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update Buku</button>
        <a href="listbuku.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php 
include("template/footer.php");

if(isset($_POST['submit'])){
    extract($_POST);
    
    // Cek apakah user mengupload gambar baru
    if($_FILES['gambar']['name'] != "") {
        $nama_gambar = $_FILES['gambar']['name'];
        $tmp_gambar = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp_gambar, "img/".$nama_gambar);
        
        // Query dengan update gambar baru
        $query = "UPDATE `buku` SET `id_kategori_buku`='$id_kategori_buku', `judul_buku`='$judul_buku', `pengarang`='$pengarang', `penerbit`='$penerbit', `tahun_terbit`='$tahun_terbit', `harga`='$harga', `gambar`='$nama_gambar' WHERE id = $id";
    } else {
        // Query tanpa mengubah gambar yang sudah ada
        $query = "UPDATE `buku` SET `id_kategori_buku`='$id_kategori_buku', `judul_buku`='$judul_buku', `pengarang`='$pengarang', `penerbit`='$penerbit', `tahun_terbit`='$tahun_terbit', `harga`='$harga' WHERE id = $id";
    }
    
    mysqli_query($connection, $query);
    header("location:listbuku.php");
}
?>