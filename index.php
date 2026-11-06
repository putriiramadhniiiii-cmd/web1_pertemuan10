<?php
require 'koneksi.php';

$sql = "SELECT p.id_produk, p.nama_produk, p.harga, p.stok,
               k.nama_kategori
        FROM produk AS p
        INNER JOIN kategori AS k ON k.id_kategori = p.id_kategori
        ORDER BY p.id_produk ASC";
$hasil = mysqli_query($koneksi, $sql);

if (!$hasil) {
    die('Query daftar produk gagal: ' . e(mysqli_error($koneksi)));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 30px; color: #263238; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 12px #ddd; }
        h1 { color: #176b87; }
        .tambah { display: inline-block; background: #176b87; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 11px; text-align: left; }
        th { background: #176b87; color: white; }
        tr:nth-child(even) { background: #f7fbfc; }
        .aksi { display: flex; gap: 8px; align-items: center; }
        .edit { color: #176b87; }
        button { border: 0; background: #dc3545; color: white; padding: 7px 10px; border-radius: 4px; cursor: pointer; }
        .kosong { padding: 15px; background: #fff3cd; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Daftar Produk</h1>
    <p>Praktikum Pemrograman Web I - Pertemuan 10</p>
    <a class="tambah" href="tambah.php">+ Tambah Produk</a>

    <?php if (mysqli_num_rows($hasil) > 0) { ?>
    <table>
        <tr>
            <th>ID</th><th>Nama Produk</th><th>Kategori</th>
            <th>Harga</th><th>Stok</th><th>Aksi</th>
        </tr>
        <?php while ($baris = mysqli_fetch_assoc($hasil)) { ?>
        <tr>
            <td><?php echo e($baris['id_produk']); ?></td>
            <td><?php echo e($baris['nama_produk']); ?></td>
            <td><?php echo e($baris['nama_kategori']); ?></td>
            <td>Rp <?php echo e(number_format((float)$baris['harga'], 0, ',', '.')); ?></td>
            <td><?php echo e($baris['stok']); ?></td>
            <td>
                <div class="aksi">
                    <a class="edit" href="edit.php?id=<?php echo e($baris['id_produk']); ?>">Edit</a>
                    <form method="post" action="hapus.php" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                        <input type="hidden" name="id" value="<?php echo e($baris['id_produk']); ?>">
                        <button type="submit">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php } ?>
    </table>
    <?php } else { ?>
        <p class="kosong">Belum ada produk. Silakan tambahkan produk baru.</p>
    <?php } ?>
</div>
</body>
</html>
