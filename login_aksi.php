<?php
require 'data/connection.php';
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

   $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
//    die($query);
   $data = mysqli_query($connection, $query);

    if (mysqli_num_rows($data)=== 1) {
        $row = mysqli_fetch_assoc($data);
        $_SESSION['login'] = true;
        $_SESSION['id'] = $row['id']; 
        $_SESSION['username'] = $row['username'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = $row['role'];

        header("location:listbuku.php");
        exit();
    
    } else {
        
        echo "<div class='container mt-5'><div class='alert alert-danger text-center shadow-sm'>";
        echo "<h4 class='alert-heading'>Akses Ditolak!</h4>";
        echo "<p>Username atau password yang Anda masukkan salah.</p><hr>";
        echo "<a href='index.php' class='btn btn-danger btn-sm'>Kembali ke Halaman Login</a>";
        echo "</div></div>";
        
        exit();
    }
}
?>