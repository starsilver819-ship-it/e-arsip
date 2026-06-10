<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])){
    echo 0;
    exit;
}

$nama = $_SESSION['nama'];

$query = mysqli_query($koneksi,"
SELECT COUNT(*) as total 
FROM disposisi 
WHERE tujuan='$nama' AND dibaca=0
");

$data = mysqli_fetch_assoc($query);

echo $data['total'];