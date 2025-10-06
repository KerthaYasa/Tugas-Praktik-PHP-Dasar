<?php
include '../koneksi.php';
$id = $_GET['mahasiswa_id'];
$mhs = $conn->query("SELECT * FROM mahasiswa WHERE id=$id")->fetch_assoc();
$nilai = $conn->query("SELECT * FROM nilai WHERE mahasiswa_id=$id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Nilai Mahasiswa</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="navbar">
  <a href="../index.php">🏫 Data Mahasiswa</a>
  <a href="index.php?mahasiswa_id=<?= $id ?>">📘 Nilai</a>
</div>

<div class="container">
  <h2>Nilai Mahasiswa</h2>
  <p><b>Nama:</b> <?= $mhs['nama'] ?><br>
     <b>NIM:</b> <?= $mhs['nim'] ?><br>
     <b>Program Studi:</b> <?= $mhs['prodi'] ?></p>

  <a href="tambah.php?mahasiswa_id=<?= $id ?>" class="action-btn">+ Tambah Nilai</a>
  <a href="../index.php" class="btn btn-secondary">← Kembali</a>

  <div class="table-wrap mt-4">
    <table>
      <tr><th>No</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai Huruf</th><th>Nilai Angka</th><th>Aksi</th></tr>
      <?php $no=1; while($n = $nilai->fetch_assoc()): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $n['mata_kuliah'] ?></td>
        <td><?= $n['sks'] ?></td>
        <td><?= $n['nilai_huruf'] ?></td>
        <td><?= $n['nilai_angka'] ?></td>
        <td class="actions">
          <a href="edit.php?id=<?= $n['id'] ?>&mahasiswa_id=<?= $id ?>" class="btn">✏️ Edit</a>
          <a href="hapus.php?id=<?= $n['id'] ?>&mahasiswa_id=<?= $id ?>" class="btn btn-danger" onclick="return confirm('Hapus nilai ini?')">🗑 Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</div>
</body>
</html>
