<?php
include 'koneksi.php';
$id = $_GET['id'];
$mhs = $conn->query("SELECT * FROM mahasiswa WHERE id=$id")->fetch_assoc();

if (isset($_POST['update'])) {
  $nim = $_POST['nim'];
  $nama = $_POST['nama'];
  $prodi = $_POST['prodi'];
  $conn->query("UPDATE mahasiswa SET nim='$nim', nama='$nama', prodi='$prodi' WHERE id=$id");
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Mahasiswa</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="navbar"><a href="index.php">← Data Mahasiswa</a></div>
<div class="form-card">
  <h2>Edit Data Mahasiswa</h2>
  <form method="POST">
    <div class="form-row"><label>NIM:</label><input type="text" name="nim" value="<?= $mhs['nim'] ?>" required></div>
    <div class="form-row"><label>Nama:</label><input type="text" name="nama" value="<?= $mhs['nama'] ?>" required></div>
    <div class="form-row"><label>Program Studi:</label><input type="text" name="prodi" value="<?= $mhs['prodi'] ?>" required></div>
    <div class="form-actions">
      <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
      <a href="index.php" class="btn btn-secondary">← Kembali</a>
    </div>
  </form>
</div>
</body>
</html>
