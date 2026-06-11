<?php
session_start();
// Proteksi: Hanya Admin
if(!isset($_SESSION['login']) || $_SESSION['role'] != 'Admin'){
    header("location:index.php");
    exit();
}

require 'data/connection.php';

$id = $_GET['id'];
$query = "DELETE FROM `buku` WHERE id = $id";
mysqli_query($connection, $query);

header("location:listbuku.php");
exit();
?>