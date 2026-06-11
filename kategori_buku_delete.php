<?php
    session_start();
    if(!isset($_SESSION['login']) || !$_SESSION['login']){
        header("location:index.php");
    }
    require 'data/connection.php';
    $query = "DELETE FROM `kategori_buku` WHERE id = ".$_GET['id'];
    mysqli_query($connection,$query);

    header("location:kategori_buku.php");
?>