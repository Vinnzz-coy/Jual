<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jual Perlengkapan Sekolah</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/logout.css">

</head>

<body>
    <header>
        <div class="container header-content">
            <div>
                <h1>Perlengkapan Sekolah</h1>
                <p class="subtitle">Toko Perlengkapan Sekolah Lengkap dan Berkualitas</p>
            </div>
            <a href="form_tambah.php" class="btn btn-add"><i class="fas fa-plus"></i> Tambah Barang</a>
            <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        </div>
    </header>

    <div class="container">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'koneksi.php';

                    $query = "SELECT * FROM tb_barang";
                    $hasil = mysqli_query($koneksi, $query);

                    while ($row = mysqli_fetch_assoc($hasil)) {
                        $stockClass = ($row['stok'] > 10) ? 'in-stock' : 'low-stock';

                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nama'] . "</td>";
                        echo "<td class='price'>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                        echo "<td><span class='stock-status " . $stockClass . "'>" . $row['stok'] . "</span></td>";
                        echo '<td class="actions">
                                <a href="form_edit.php?id=' . $row['id'] . '" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <a href="javascript:void(0)" onclick="showDeleteModal(' . $row['id'] . ', \'' . $row['nama'] . '\', ' . $row['harga'] . ', ' . $row['stok'] . ')" class="btn btn-delete"><i class="fas fa-trash"></i> Hapus</a>
                              </td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-overlay" id="deleteModal">
        <div class="modal-container">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Konfirmasi Hapus</h3>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus barang ini?</p>
                <div class="item-details">
                    <p><strong>ID:</strong> <span id="deleteItemId"></span></p>
                    <p><strong>Nama:</strong> <span id="deleteItemName"></span></p>
                    <p><strong>Harga:</strong> <span id="deleteItemPrice"></span></p>
                    <p><strong>Stok:</strong> <span id="deleteItemStock"></span></p>
                </div>
                <p>Tindakan ini tidak dapat dibatalkan.</p>
                <div class="modal-actions">
                    <button class="btn-cancel" onclick="hideDeleteModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <a href="#" id="confirmDeleteBtn" class="btn-confirm-delete">
                        <i class="fas fa-check"></i> Ya, Hapus
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="toast" id="notificationToast">
        <i class="fas fa-check-circle"></i>
        <span id="notificationMessage">Barang berhasil dihapus</span>
    </div>

    <footer class="container">
        <p>&copy; <?php echo date('Y'); ?> Toko Perlengkapan Sekolah. Semua hak dilindungi.</p>
    </footer>

    <script>
    function showDeleteModal(id, name, price, stock) {
        document.getElementById('deleteItemId').textContent = id;
        document.getElementById('deleteItemName').textContent = name;
        document.getElementById('deleteItemPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('deleteItemStock').textContent = stock;
        document.getElementById('confirmDeleteBtn').href = 'proses_hapus.php?id=' + id;

        document.getElementById('deleteModal').classList.add('active');
    }

    function hideDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    function showNotification(message, type) {
        const toast = document.getElementById('notificationToast');
        const notificationMessage = document.getElementById('notificationMessage');

        toast.className = 'toast show';
        if (type === 'success') {
            toast.classList.add('success');
            toast.querySelector('i').className = 'fas fa-check-circle';
        } else if (type === 'error') {
            toast.classList.add('error');
            toast.querySelector('i').className = 'fas fa-exclamation-circle';
        }

        notificationMessage.textContent = message;

        setTimeout(function() {
            toast.classList.remove('show');
        }, 3000);
    }

    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const message = urlParams.get('message');

    if (status === 'success') {
        showNotification(message || 'Barang berhasil dihapus', 'success');
    } else if (status === 'error') {
        showNotification(message || 'Terjadi kesalahan saat menghapus barang', 'error');
    }
    </script>
</body>

</html>