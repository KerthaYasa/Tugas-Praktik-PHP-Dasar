<?php
include '../koneksi.php';
$id = $_GET['id'];
$nilai = $conn->query("SELECT * FROM nilai WHERE id=$id")->fetch_assoc();
$mhs = $conn->query("SELECT * FROM mahasiswa WHERE id={$nilai['mahasiswa_id']}")->fetch_assoc();

if (isset($_POST['update'])) {
  $mata_kuliah = $_POST['mata_kuliah'];
  $sks = $_POST['sks'];
  $nilai_huruf = $_POST['nilai_huruf'];
  $nilai_angka = $_POST['nilai_angka'];

  $conn->query("UPDATE nilai SET mata_kuliah='$mata_kuliah', sks='$sks', nilai_huruf='$nilai_huruf', nilai_angka='$nilai_angka' WHERE id=$id");
  header("Location: index.php?mahasiswa_id={$nilai['mahasiswa_id']}");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Nilai</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="navbar">
  <a href="../index.php">🏫 Data Mahasiswa</a>
  <a href="index.php?mahasiswa_id=<?= $mhs['id'] ?>">📘 Nilai</a>
</div>

<div class="form-card">
  <h2>Edit Nilai Mahasiswa</h2>
  <p><b>Nama:</b> <?= $mhs['nama'] ?> | <b>NIM:</b> <?= $mhs['nim'] ?> | <b>Prodi:</b> <?= $mhs['prodi'] ?></p>

  <form method="POST">
    <div class="form-row"><label>Mata Kuliah:</label><input type="text" name="mata_kuliah" value="<?= $nilai['mata_kuliah'] ?>" required></div>
    <div class="form-row"><label>SKS:</label><input type="number" name="sks" value="<?= $nilai['sks'] ?>" required></div>
    <div class="form-row"><label>Nilai Huruf:</label>
      <select name="nilai_huruf" required>
        <?php foreach(['A','B','C','D','E'] as $opt): ?>
          <option value="<?= $opt ?>" <?= $opt==$nilai['nilai_huruf']?'selected':'' ?>><?= $opt ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-row"><label>Nilai Angka:</label><input type="number" step="0.01" name="nilai_angka" value="<?= $nilai['nilai_angka'] ?>" required></div>

    <div class="form-actions">
      <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
      <a href="index.php?mahasiswa_id=<?= $mhs['id'] ?>" class="btn btn-secondary">← Kembali</a>
    </div>
  </form>
</div>
</body>
</html>
