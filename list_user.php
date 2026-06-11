<?php include("template/header.php"); ?>
<div class="container">
    <h1>List User</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">Alamat</th>
                <th scope="col">Email</th>
                <th scope="col">No Telepon</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Level User</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $x=1;
                $query = "SELECT * FROM user";
                $data = mysqli_query($connection, $query);
                while($data_row = mysqli_fetch_assoc($data)){
                    ?>
                        <tr>
                            <th scope="row"><?=$x?></th>
                            <td><?=$data_row['nama']?></td>
                            <td><?=$data_row['alamat']?></td>
                            <td><?=$data_row['email']?></td>
                            <td><?=$data_row['no_telp']?></td>
                            <td>
                                <?php
                                    if($data_row['jenis_kelamin'] == "L"){
                                        echo "Laki-Laki";
                                    }
                                    else{
                                        echo "Perempuan";
                                    }
                                ?>
                            </td>
                            <td><?=$data_row['role']?></td>
                        </tr>
                    <?php
                    $x++;
                }
            ?>
        </tbody>
    </table>
</div>    
<?php include("template/footer.php"); ?>