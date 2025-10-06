<?php include 'koneksi.php'; 
if (isset($_POST['simpan'])) {
  $nim = $_POST['nim'];
  $nama = $_POST['nama'];
  $prodi = $_POST['prodi'];
  $conn->query("INSERT INTO mahasiswa (nim, nama, prodi) VALUES ('$nim', '$nama', '$prodi')");
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Mahasiswa</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="navbar"><a href="index.php">← Data Mahasiswa</a></div>
<div class="form-card">
  <h2>Tambah Data Mahasiswa</h2>
  <form method="POST">
    <div class="form-row"><label>NIM:</label><input type="text" name="nim" required></div>
    <div class="form-row"><label>Nama:</label><input type="text" name="nama" required></div>
    <div class="form-row"><label>Program Studi:</label><input type="text" name="prodi" required></div>
    <div class="form-actions">
      <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
      <a href="index.php" class="btn btn-secondary">← Kembali</a>
    </div>
  </form>
</div>
</body>
</html>
