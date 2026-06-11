<?php

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "tokobuku";

$connection = new mysqli($dbservername, $dbusername ,$dbpassword,$dbname);

if ($connection ->connect_error) {
    die("koneksi gagal" . $connection->connect_error );
}

?>