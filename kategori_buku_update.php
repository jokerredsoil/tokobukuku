<?php
    include("template/header.php");
    $query = "SELECT * FROM `kategori_buku` WHERE id = ".$_GET['id']; 
    $data = mysqli_query($connection,$query);
    $data_row = mysqli_fetch_assoc($data);
?>
<div class="container">
    <h1>Ubah Kategori</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>?id=$_GET['id']" method="post">
        <input type="hidden" name="id"value="<?=$_GET['id']?>">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" id="nama" value="<?=$data_row['nama']?>">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php 
    include("template/footer.php");

    if(isset($_POST['submit'])){
        extract($_POST);
        $query = "UPDATE `kategori_buku` SET `nama`='$nama' WHERE id = $id";
        mysqli_query($connection,$query);
        header("location:kategori_buku.php");
    }
?>