<?php 
include("template/header.php"); 

// Proteksi: Hanya Admin yang bisa tambah buku
if ($_SESSION['role'] != 'Admin') {
    header("location:listbuku.php");
    exit();
}
?>

<div class="container mt-4">
    <h1>Tambah Buku Baru</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3">
            <label for="judul_buku" class="form-label">Judul Buku</label>
            <input type="text" name="judul_buku" class="form-control" id="judul_buku" required>
        </div>
        
        <div class="mb-3">
            <label for="id_kategori_buku" class="form-label">Kategori Buku</label>
            <select name="id_kategori_buku" class="form-select" id="id_kategori_buku" required>
                <option value="">-- Pilih Kategori --</option>
                <?php
                $kat_query = mysqli_query($connection, "SELECT * FROM kategori_buku");
                while($kat = mysqli_fetch_assoc($kat_query)) {
                    echo "<option value='".$kat['id']."'>".$kat['nama']."</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="pengarang" class="form-label">Pengarang</label>
            <input type="text" name="pengarang" class="form-control" id="pengarang" required>
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" name="penerbit" class="form-control" id="penerbit" required>
        </div>

        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="text" name="tahun_terbit" class="form-control" id="tahun_terbit" maxlength="4" required>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" id="harga" required>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Cover Buku</label>
            <input type="file" name="gambar" class="form-control" id="gambar" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Simpan Buku</button>
        <a href="listbuku.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?php 
include("template/footer.php");

if(isset($_POST['submit'])){
    extract($_POST);
    
    // Logika upload gambar sederhana ala prosedural
    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_gambar = $_FILES['gambar']['tmp_name'];
    
    // Pindahkan file gambar ke dalam folder 'img'
    move_uploaded_file($tmp_gambar, "img/".$nama_gambar);

    $query = "INSERT INTO `buku`(`id_kategori_buku`, `judul_buku`, `pengarang`, `penerbit`, `tahun_terbit`, `harga`, `gambar`) 
              VALUES ('$id_kategori_buku', '$judul_buku', '$pengarang', '$penerbit', '$tahun_terbit', '$harga', '$nama_gambar')";
    
    mysqli_query($connection, $query);
    header("location:listbuku.php");
}
?>