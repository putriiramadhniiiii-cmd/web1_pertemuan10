# Laporan Praktikum Pemrograman Web I - Pertemuan 10

## Identitas
- Nama: Putri Ramadhani
- NIM: 25012070
- Kelas: 25M31
- Tanggal: ....................................

## Judul
PHP Dasar dan CRUD Database dengan MySQLi

## Tujuan
1. Menghubungkan PHP dengan MySQL/MariaDB menggunakan MySQLi.
2. Membaca data produk dan kategori menggunakan SELECT JOIN.
3. Menambah, mengubah, dan menghapus produk.
4. Memvalidasi masukan dan menggunakan prepared statement.
5. Mengamankan keluaran HTML menggunakan htmlspecialchars().

## Persiapan
Database yang digunakan adalah `web1_pertemuan09` dari praktikum pertemuan 9. Tabel yang digunakan adalah `kategori` dan `produk`. Lima file aplikasi: `koneksi.php`, `index.php`, `tambah.php`, `edit.php`, dan `hapus.php`.

## Hasil Praktikum
Aplikasi menampilkan daftar produk beserta kategori, harga, stok, dan tombol aksi. Pengguna dapat menambah produk melalui formulir, mengubah data produk berdasarkan ID, serta menghapus produk melalui metode POST.

## Tabel Pengujian
| No. | Skenario | Hasil yang diharapkan | Hasil aktual | Status | Bukti |
|---|---|---|---|---|---|
| 1 | Server database dimatikan lalu index.php dibuka | Pesan koneksi ringkas | Isi setelah diuji | Isi | 01-koneksi-gagal.png |
| 2 | Membuka index.php | Produk dan kategori tampil sesuai JOIN | Isi setelah diuji | Isi | 02-daftar-produk.png |
| 3 | Menambah produk valid | Satu baris baru muncul | Isi setelah diuji | Isi | 03-tambah-berhasil.png |
| 4 | Harga 0 atau stok negatif | Data ditolak | Isi setelah diuji | Isi | 04-validasi-gagal.png |
| 5 | Mengedit ID valid | Hanya produk terpilih berubah | Isi setelah diuji | Isi | 05-edit-berhasil.png |
| 6 | Membuka edit.php?id=999999 | Pesan Produk tidak ditemukan, HTTP 404 | Isi setelah diuji | Isi | 06-id-tidak-ada.png |
| 7 | Menghapus satu produk melalui tombol | Hanya produk tersebut hilang | Isi setelah diuji | Isi | 07-hapus-berhasil.png |
| 8 | Membuka hapus.php melalui GET | HTTP 405 dan data tidak terhapus | Isi setelah diuji | Isi | 08-hapus-get-ditolak.png |
| 9 | Nama produk diisi `<b>Contoh</b>` | Tag tampil sebagai teks biasa | Isi setelah diuji | Isi | 09-html-escape.png |

## Jawaban Tugas Mandiri

### 1. Menambahkan dua produk pada dua kategori berbeda
Tambahkan produk pertama melalui `tambah.php`, misalnya:
- Nama: Penghapus
- Kategori: Alat Tulis
- Harga: 4000
- Stok: 15

Tambahkan produk kedua pada kategori berbeda, misalnya:
- Nama: Mouse Pad
- Kategori: Aksesori Komputer
- Harga: 18000
- Stok: 10

Pilih kategori dari daftar pada formulir. Jangan menebak ID kategori; aplikasi mengirim ID dari pilihan kategori yang tersedia.

### 2. Mengubah harga dan stok
Pilih salah satu produk baru, klik Edit, kemudian ubah nilainya. Contoh:
- Sebelum: Mouse Pad, harga Rp18.000, stok 10.
- Sesudah: Mouse Pad, harga Rp20.000, stok 12.

Sesuaikan bagian ini dengan nilai yang benar-benar terlihat di database setelah pengujian.

### 3. Menghapus produk baru kedua
Klik Hapus pada produk baru kedua (contoh Mouse Pad). Periksa daftar dan tabel `produk`. Produk baru pertama dan produk lain harus tetap ada.

### 4. Perbedaan mysqli_query() dan mysqli_prepare()
`mysqli_query()` digunakan untuk menjalankan SQL langsung yang tidak menerima nilai dari pengguna, contohnya SELECT JOIN pada halaman daftar. `mysqli_prepare()` menyiapkan SQL dengan tanda tanya (?) sebagai tempat nilai. Nilai dari formulir kemudian diikat memakai `bind_param()` sebelum perintah dijalankan. Cara ini membantu memisahkan perintah SQL dari data masukan pengguna.

### 5. Alur tombol Hapus
Tombol Hapus pada `index.php` berada di dalam formulir dengan metode POST. Form mengirim ID produk ke `hapus.php`. File tersebut memeriksa metode permintaan dan memvalidasi ID. Selanjutnya prepared statement menjalankan DELETE dengan kondisi `WHERE id_produk = ?`. Setelah berhasil, browser diarahkan kembali ke `index.php` dan daftar dibaca ulang dari database.

## Analisis Alur Data
Browser mengirim permintaan ke file PHP. PHP memvalidasi masukan, lalu MySQLi menjalankan query ke database. Database mengembalikan hasil atau menyimpan perubahan. PHP kemudian menampilkan daftar terbaru atau mengarahkan browser kembali ke halaman daftar.

## Kendala dan Solusi
1. Koneksi gagal: pastikan MySQL aktif, nama database `web1_pertemuan09` benar, dan akun MySQL sesuai.
2. Tabel tidak ditemukan: pastikan tabel `kategori` dan `produk` sudah dibuat pada pertemuan 9.
3. Header already sent: pastikan tidak ada spasi atau HTML sebelum `header()`.
4. Produk tidak ditemukan: periksa ID pada URL dan isi tabel produk.
5. Data tidak berubah: periksa nilai ID, urutan parameter `bind_param()`, dan kondisi WHERE.

## Simpulan
Praktikum ini menunjukkan penggunaan MySQLi untuk menghubungkan PHP dengan database dan menjalankan operasi CRUD. SELECT JOIN digunakan untuk menampilkan produk beserta kategori. INSERT, UPDATE, dan DELETE menggunakan prepared statement agar nilai dari formulir diikat sebagai parameter. Validasi input dan `htmlspecialchars()` membantu menjaga data dan tampilan aplikasi.

## Bukti Screenshot
Ambil screenshot dari hasil aplikasi yang benar-benar dijalankan. Simpan dalam folder `dokumentasi/` dengan nama sesuai kolom Bukti pada tabel pengujian. Jangan mengisi hasil aktual atau status Lulus sebelum pengujian dilakukan.
