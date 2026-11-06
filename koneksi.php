<?php
// Koneksi ke database dari Modul Pertemuan 9
$host = '127.0.0.1';
$namaDatabase = 'web1_pertemuan09';
$pengguna = 'root';
$kataSandi = '';

$koneksi = mysqli_connect($host, $pengguna, $kataSandi, $namaDatabase);

if (!$koneksi) {
    die('Koneksi database gagal. Periksa MySQL, nama database, dan akun lokal.');
}

mysqli_set_charset($koneksi, 'utf8mb4');

// Fungsi untuk mengamankan teks saat ditampilkan ke HTML
function e($nilai) {
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}
?>
