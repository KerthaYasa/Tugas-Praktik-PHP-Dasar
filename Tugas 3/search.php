<?php
include 'koneksi.php';

$keyword = isset($_GET['keyword']) ? $conn->real_escape_string($_GET['keyword']) : '';

$sql = "SELECT * FROM mahasiswa 
        WHERE nama LIKE '%$keyword%' 
        OR nim LIKE '%$keyword%' 
        OR prodi LIKE '%$keyword%'
        ORDER BY id ASC";
$result = $conn->query($sql);

if (!$result) {
  echo "<tr><td colspan='5'>Terjadi kesalahan: " . htmlspecialchars($conn->error) . "</td></tr>";
  exit;
}

if ($result->num_rows === 0) {
  echo "<tr><td colspan='5'>Data tidak ditemukan.</td></tr>";
  exit;
}

while ($row = $result->fetch_assoc()) {
  $id = (int)$row['id'];
  $nama = htmlspecialchars($row['nama']);
  $nim = htmlspecialchars($row['nim']);
  $prodi = htmlspecialchars($row['prodi']);

  echo "
  <tr>
    <td>$id</td>
    <td>$nama</td>
    <td>$nim</td>
    <td>$prodi</td>
    <td class='actions'>
      <a href='edit.php?id=$id' class='btn'>✏️ Edit</a>
      <a href='hapus.php?id=$id' class='btn btn-danger' onclick=\"return confirm('Hapus data ini?')\">🗑 Hapus</a>
      <a href='nilai/tambah.php?mahasiswa_id=$id' class='btn'>➕ Tambah Nilai</a>
      <a href='nilai/index.php?mahasiswa_id=$id' class='btn btn-secondary'>📊 Lihat Nilai</a>
    </td>
  </tr>";
}
?>
