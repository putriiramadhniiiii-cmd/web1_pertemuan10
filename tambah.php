<?php
require 'koneksi.php';

$kategori = mysqli_query($koneksi, "SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori");
if (!$kategori) {
    die('Data kategori gagal dibaca.');
}

$error = '';
$nama = isset($_POST['nama_produk']) ? trim($_POST['nama_produk']) : '';
$hargaInput = isset($_POST['harga']) ? $_POST['harga'] : '';
$stokInput = isset($_POST['stok']) ? $_POST['stok'] : '';
$kategoriInput = isset($_POST['id_kategori']) ? $_POST['id_kategori'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $harga = filter_var($hargaInput, FILTER_VALIDATE_FLOAT);
    $stok = filter_var($stokInput, FILTER_VALIDATE_INT);
    $idKategori = filter_var($kategoriInput, FILTER_VALIDATE_INT);

    if ($nama == '' || $harga === false || $harga <= 0 ||
        $stok === false || $stok < 0 ||
        $idKategori === false || $idKategori < 1) {
        $error = 'Isi semua data dengan benar. Harga harus positif dan stok tidak boleh negatif.';
    } else {
        $cek = mysqli_prepare($koneksi, 'SELECT COUNT(*) FROM kategori WHERE id_kategori = ?');
        mysqli_stmt_bind_param($cek, 'i', $idKategori);
        mysqli_stmt_execute($cek);
        mysqli_stmt_bind_result($cek, $jumlahKategori);
        mysqli_stmt_fetch($cek);
        mysqli_stmt_close($cek);

        if ((int)$jumlahKategori == 0) {
            $error = 'Kategori tidak ditemukan.';
        } else {
            $sql = 'INSERT INTO produk (id_kategori, nama_produk, harga, stok) VALUES (?, ?, ?, ?)';
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, 'isdi', $idKategori, $nama, $harga, $stok);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; margin: 30px; }
        .box { max-width: 550px; margin: auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 12px #ddd; }
        h1 { color: #176b87; }
        label { display: block; margin-top: 14px; }
        input, select { width: 100%; padding: 10px; margin-top: 6px; box-sizing: border-box; border: 1px solid #bbb; border-radius: 5px; }
        button { margin-top: 18px; background: #176b87; color: white; border: 0; padding: 11px 18px; border-radius: 5px; cursor: pointer; }
        .error { background: #f8d7da; color: #842029; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
<div class="box">
    <h1>Tambah Produk</h1>
    <?php if ($error != '') { ?><p class="error"><?php echo e($error); ?></p><?php } ?>
    <form method="post">
        <label>Nama Produk</label>
        <input type="text" name="nama_produk" value="<?php echo e($nama); ?>" required>

        <label>Harga</label>
        <input type="number" name="harga" min="0.01" step="0.01" value="<?php echo e($hargaInput); ?>" required>

        <label>Stok</label>
        <input type="number" name="stok" min="0" step="1" value="<?php echo e($stokInput); ?>" required>

        <label>Kategori</label>
        <select name="id_kategori" required>
            <option value="">Pilih kategori</option>
            <?php while ($item = mysqli_fetch_assoc($kategori)) {
                $terpilih = ((string)$kategoriInput == (string)$item['id_kategori']) ? 'selected' : '';
            ?>
                <option value="<?php echo e($item['id_kategori']); ?>" <?php echo $terpilih; ?>>
                    <?php echo e($item['nama_kategori']); ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit">Simpan Produk</button>
    </form>
    <p><a href="index.php">Kembali ke daftar</a></p>
</div>
</body>
</html>
