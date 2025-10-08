<?php
require_once 'koneksi.php';

// Ambil semua data mahasiswa
$result = $conn->query("SELECT * FROM mahasiswa ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa</title>
  <link rel="stylesheet" href="assets/style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container">
  <h1>📘 Data Mahasiswa</h1>

  <!-- Search bar + tombol tambah -->
  <div class="header-actions">
    <input type="text" id="searchInput" placeholder="🔍 Cari mahasiswa...">
    <a href="tambah.php" class="btn primary">➕ Tambah Mahasiswa</a>
  </div>

  <!-- Tabel Data Mahasiswa -->
  <div class="table-wrapper">
    <table class="table" id="mahasiswaTable">
      <thead>
        <tr>
          <th>No</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Program Studi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php $no = 1; while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['nim']); ?></td>
              <td><?= htmlspecialchars($row['nama']); ?></td>
              <td><?= htmlspecialchars($row['prodi']); ?></td>
              <td class="actions-col">
                <a href="edit.php?id=<?= $row['id']; ?>" class="btn small primary">✏️ Edit</a>
                <button class="btn small danger btnDelete" 
                        data-id="<?= $row['id']; ?>" 
                        data-nama="<?= htmlspecialchars($row['nama']); ?>">
                  🗑️ Hapus
                </button>
                <a href="nilai/tambah.php?mahasiswa_id=<?= $row['id']; ?>&return=main" class="btn small secondary">➕ Nilai</a>
                <a href="nilai/index.php?mahasiswa_id=<?= $row['id']; ?>" class="btn small secondary">📊 Lihat</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="empty">Belum ada data mahasiswa.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="confirmModal" class="modal">
  <div class="modal-content">
    <h3>⚠️ Konfirmasi Hapus</h3>
    <p id="confirmText">Yakin ingin menghapus data ini?</p>
    <div class="modal-actions">
      <button id="cancelBtn" class="btn secondary">Batal</button>
      <button id="confirmBtn" class="btn danger">Hapus</button>
    </div>
  </div>
</div>

<!-- Toast Container -->
<div id="toastContainer"></div>

<script>
// Toast Function
function showToast(type, message) {
  const toast = $('<div class="toast ' + type + '">' + message + '</div>');
  $('#toastContainer').append(toast);
  setTimeout(() => toast.remove(), 3500);
}

$(document).ready(function() {
  // Pencarian realtime
  $("#searchInput").on("keyup", function() {
    const value = $(this).val().toLowerCase();
    $("#mahasiswaTable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  // Modal Konfirmasi Hapus
  $(".btnDelete").on("click", function() {
    const id = $(this).data("id");
    const nama = $(this).data("nama");

    $("#confirmText").text("Yakin ingin menghapus mahasiswa '" + nama + "'?");
    $("#confirmModal").fadeIn(200).css("display", "flex");

    // Tombol Hapus
    $("#confirmBtn").off().on("click", function() {
      $.post("hapus.php", { id: id }, function(response) {
        showToast(response.status, response.message);
        if (response.status === "success") {
          setTimeout(() => location.reload(), 1500);
        }
      }, "json").fail(function() {
        showToast("error", "Terjadi kesalahan saat menghapus data");
      });
      $("#confirmModal").fadeOut(200);
    });

    // Tombol Batal
    $("#cancelBtn").off().on("click", function() {
      $("#confirmModal").fadeOut(200);
    });
  });

  // Klik luar modal = tutup
  $(document).on("click", ".modal", function(e) {
    if ($(e.target).is(".modal")) {
      $(this).fadeOut(200);
    }
  });

  // ESC key untuk tutup modal
  $(document).on("keydown", function(e) {
    if (e.key === "Escape" && $("#confirmModal").is(":visible")) {
      $("#confirmModal").fadeOut(200);
    }
  });
});
</script>

</body>
</html>