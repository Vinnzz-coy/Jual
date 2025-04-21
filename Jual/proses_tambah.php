<?php 
include 'koneksi.php'; 

$nama = $_POST['nama']; 
$harga = $_POST['harga']; 
$stok = $_POST['stok']; 

$query = "INSERT INTO tb_barang (nama, harga, stok) VALUES ('$nama', '$harga', '$stok')"; 
mysqli_query($koneksi, $query); 

header('Location: index.php'); 
?>