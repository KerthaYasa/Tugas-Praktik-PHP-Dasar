<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Mahasiswa</title>
  <link rel="stylesheet" href="assets/style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="assets/script.js"></script>
</head>
<body>
  <div class="navbar">
    <a href="index.php">🏫 Data Mahasiswa</a>
  </div>

  <div class="container">
    <div class="header-row">    
      <h2>Data Mahasiswa</h2>
      <a href="tambah.php" class="action-btn">+ Tambah Mahasiswa</a>
    </div>

    <input type="text" id="search" placeholder="Cari nama, NIM, atau prodi..." class="search-input">

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Program Studi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="table-body">
        <?php
          $result = $conn->query("SELECT * FROM mahasiswa ORDER BY id ASC");
          while ($row = $result->fetch_assoc()):
        ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['nim'] ?></td>
            <td><?= $row['prodi'] ?></td>
            <td class="actions">
              <a href="edit.php?id=<?= $row['id'] ?>" class="btn">✏️ Edit</a>
              <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Hapus data ini?')">🗑 Hapus</a>
              <a href="nilai/tambah.php?mahasiswa_id=<?= $row['id'] ?>" class="btn">➕ Tambah Nilai</a>
              <a href="nilai/index.php?mahasiswa_id=<?= $row['id'] ?>" class="btn btn-secondary">📊 Lihat Nilai</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
