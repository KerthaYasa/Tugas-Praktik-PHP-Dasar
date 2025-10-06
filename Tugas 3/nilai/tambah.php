<?php
include '../koneksi.php';
$mahasiswa_id = $_GET['mahasiswa_id'];
$mhs = $conn->query("SELECT * FROM mahasiswa WHERE id=$mahasiswa_id")->fetch_assoc();

if (isset($_POST['simpan'])) {
  $mata_kuliah = $_POST['mata_kuliah'];
  $sks = $_POST['sks'];
  $nilai_huruf = $_POST['nilai_huruf'];
  $nilai_angka = $_POST['nilai_angka'];

  $stmt = $conn->prepare("INSERT INTO nilai (mahasiswa_id, mata_kuliah, sks, nilai_huruf, nilai_angka) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("isisd", $mahasiswa_id, $mata_kuliah, $sks, $nilai_huruf, $nilai_angka);
  $stmt->execute();

  header("Location: index.php?mahasiswa_id=$mahasiswa_id");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Nilai</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="navbar">
  <a href="../index.php">🏫 Data Mahasiswa</a>
  <a href="index.php?mahasiswa_id=<?= $mahasiswa_id ?>">📘 Data Nilai</a>
</div>

<div class="form-card">
  <h2>Tambah Nilai Mahasiswa</h2>
  <p><b>Nama:</b> <?= $mhs['nama'] ?><br>
     <b>NIM:</b> <?= $mhs['nim'] ?><br>
     <b>Program Studi:</b> <?= $mhs['prodi'] ?></p>

  <form method="POST">
    <div class="form-row"><label>Mata Kuliah:</label><input type="text" name="mata_kuliah" required></div>
    <div class="form-row"><label>SKS:</label><input type="number" name="sks" min="1" required></div>
    <div class="form-row"><label>Nilai Huruf:</label>
      <select name="nilai_huruf" required>
        <option value="A">A</option><option value="B">B</option>
        <option value="C">C</option><option value="D">D</option><option value="E">E</option>
      </select>
    </div>
    <div class="form-row"><label>Nilai Angka:</label><input type="number" step="0.01" name="nilai_angka" required></div>

    <div class="form-actions">
      <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
      <a href="index.php?mahasiswa_id=<?= $mahasiswa_id ?>" class="btn btn-secondary">← Kembali</a>
    </div>
  </form>
</div>
</body>
</html>
