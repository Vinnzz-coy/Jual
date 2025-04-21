<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Perlengkapan Sekolah</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/from_tambah.css">
</head>

<body>
    <header>
        <div class="header-content">
            <div>
                <h1>Perlengkapan Sekolah</h1>
                <p class="subtitle">Toko Perlengkapan Sekolah Lengkap dan Berkualitas</p>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Tambah Barang</h2>
            <form action="proses_tambah.php" method="post">
                <div class="form-group">
                    <label for="nama">Nama Barang:</label>
                    <div class="input-icon">
                        <i class="fas fa-box"></i>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama barang" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="harga">Harga (Rp):</label>
                    <div class="input-icon">
                        <i class="fas fa-tag"></i>
                        <input type="text" id="harga" name="harga" placeholder="Masukkan harga barang" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="stok">Stok:</label>
                    <div class="input-icon">
                        <i class="fas fa-cubes"></i>
                        <input type="text" id="stok" name="stok" placeholder="Masukkan jumlah stok" required />
                    </div>
                </div>

                <div class="actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Barang
                    </button>

                    <a href="index.php" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <footer class="container">
        <p>&copy; <?php echo date('Y'); ?> Toko Perlengkapan Sekolah. Semua hak dilindungi.</p>
    </footer>
</body>

</html>