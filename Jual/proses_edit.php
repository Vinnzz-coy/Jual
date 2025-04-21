<?php 
include 'koneksi.php'; 

$id = $_POST['id']; 
$nama = $_POST['nama']; 
$harga = $_POST['harga']; 
$stok = $_POST['stok']; 

$query = "UPDATE tb_barang SET nama='$nama', harga='$harga', stok='$stok' WHERE id='$id'"; 
mysqli_query($koneksi, $query); 

header('Location: index.php'); 
?>