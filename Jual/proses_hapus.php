<?php
include 'koneksi.php';

$id = $_GET['id'];

$query_delete = "DELETE FROM tb_barang WHERE id='$id'";
$hasil_delete = mysqli_query($koneksi, $query_delete);

if ($hasil_delete) {
    $query_create_temp = "CREATE TEMPORARY TABLE temp_barang SELECT * FROM tb_barang";
    mysqli_query($koneksi, $query_create_temp);

    $query_truncate = "TRUNCATE TABLE tb_barang";
    mysqli_query($koneksi, $query_truncate);

    $query_alter = "ALTER TABLE tb_barang AUTO_INCREMENT = 1";
    mysqli_query($koneksi, $query_alter);

    $query_reinsert = "INSERT INTO tb_barang (nama, harga, stok) SELECT nama, harga, stok FROM temp_barang";
    $hasil_reinsert = mysqli_query($koneksi, $query_reinsert);

    if ($hasil_reinsert) {
        header("Location: index.php?status=success&message=Barang berhasil dihapus dan ID diurutkan kembali");
    } else {
        header("Location: index.php?status=error&message=Barang berhasil dihapus tetapi gagal mengatur ulang ID");
    }
} else {
    header("Location: index.php?status=error&message=Gagal menghapus barang");
}