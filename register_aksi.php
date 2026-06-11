<?php
    require 'data/connection.php';

    $query = "SELECT id FROM user WHERE username = '".$_POST['username']."'";

    $data = mysqli_query($connection, $query);

    $error = "";
    if (!mysqli_num_rows($data) >= 1) {
        if($_POST['confirm_password'] == $_POST['password']){
            extract($_POST);
            // $username = $_POST['username'];
            // $password = $_POST['password'];
            // $confirm_password = $_POST['confirm_password'];
            // $nama = $_POST['nama'];
            // $alamat = $_POST['alamat'];
            // $email = $_POST['email'];
            // $no_telp = $_POST['no_telp'];
            // $jenis_kelamin = $_POST['jenis_kelamin'];


            // menginput data ke database
            mysqli_query($connection, "insert into user values('','$username','$password','$nama', 'User','$alamat','$email','$no_telp','$jenis_kelamin')");
            die();

            header("location:index.php");
        }
        else{
            $error = "data password dan konfirmasi password berbeda";
        }        
    }
    else{
        $error = "Username Sudah Terdaftar";
    }
    die($error);
    header("location:register.php");
?>