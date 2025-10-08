<?php
require_once '../koneksi.php';

if (!isset($_GET["mahasiswa_id"])) {
    header("Location: ../index.php");
    exit;
}

$mahasiswa_id = intval($_GET["mahasiswa_id"]);

// Ambil data mahasiswa
$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $mahasiswa_id);
$stmt->execute();
$mhs = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$mhs) {
    die("<div class='container'><h1>❌ Data Tidak Ditemukan</h1><p>Mahasiswa tidak ditemukan.</p><a href='../index.php' class='btn primary'>← Kembali</a></div>");
}

// Ambil daftar nilai
$stmt = $conn->prepare("SELECT * FROM nilai WHERE mahasiswa_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $mahasiswa_id);
$stmt->execute();
$nilai = $stmt->get_result();
$stmt->close();

// Hitung IPK
$total_sks = 0;
$total_nilai = 0;
$stmt = $conn->prepare("SELECT sks, nilai_angka FROM nilai WHERE mahasiswa_id = ?");
$stmt->bind_param("i", $mahasiswa_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $total_sks += $row['sks'];
    $total_nilai += ($row['sks'] * $row['nilai_angka']);
}
$stmt->close();
$ipk = ($total_sks > 0) ? round($total_nilai / $total_sks, 2) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Mahasiswa - <?= htmlspecialchars($mhs['nama']); ?></title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container">
    <h1>📊 Nilai Mahasiswa</h1>

    <!-- Profil Mahasiswa -->
    <div class="card profile">
        <h2>👤 <?= htmlspecialchars($mhs['nama']); ?></h2>
        <p><strong>NIM:</strong> <?= htmlspecialchars($mhs['nim']); ?></p>
        <p><strong>Program Studi:</strong> <?= htmlspecialchars($mhs['prodi']); ?></p>
        <?php if ($total_sks > 0): ?>
        <p><strong>Total SKS:</strong> <?= $total_sks; ?> SKS | <strong>IPK:</strong> <span style="color: <?= $ipk >= 3.00 ? '#10b981' : ($ipk >= 2.00 ? '#f59e0b' : '#ef4444'); ?>; font-weight: 700;"><?= number_format($ipk, 2); ?></span></p>
        <?php endif; ?>
    </div>

    <!-- Header Actions -->
    <div class="header-actions">
        <h2 style="margin: 0; font-size: 18px; font-weight: 600; color: #1f2937;">Daftar Nilai</h2>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="tambah.php?mahasiswa_id=<?= $mahasiswa_id; ?>&return=nilai" class="btn primary">➕ Tambah Nilai</a>
            <a href="../index.php" class="btn secondary">← Kembali</a>
        </div>
    </div>

    <!-- Tabel Nilai -->
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Mata Kuliah</th>
                    <th style="width: 80px;">SKS</th>
                    <th style="width: 100px;">Nilai Huruf</th>
                    <th style="width: 100px;">Nilai Angka</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($nilai->num_rows > 0): ?>
                    <?php 
                    $no = 1;
                    // Reset pointer untuk loop kedua
                    $nilai->data_seek(0);
                    while($row = $nilai->fetch_assoc()): 
                    ?>
                        <tr>
                            <td style="text-align: center;"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['mata_kuliah']); ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['sks']); ?></td>
                            <td style="text-align: center; font-weight: 600;"><?= htmlspecialchars($row['nilai_huruf']); ?></td>
                            <td style="text-align: center; font-weight: 600;"><?= number_format($row['nilai_angka'], 2); ?></td>
                            <td class="actions-col">
                                <a href="edit.php?id=<?= $row['id']; ?>&mahasiswa_id=<?= $mahasiswa_id; ?>" class="btn small primary">✏️ Edit</a>
                                <button class="btn small danger btnDelete" data-id="<?= $row['id']; ?>" data-mk="<?= htmlspecialchars($row['mata_kuliah']); ?>">🗑️ Hapus</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty">
                            📋 Belum ada data nilai. Klik "Tambah Nilai" untuk menambahkan data.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Toast Container -->
<div id="toastContainer"></div>

<!-- Modal Konfirmasi Hapus -->
<div id="confirmModal" class="modal">
  <div class="modal-content">
    <h3>⚠️ Konfirmasi Hapus</h3>
    <p id="confirmText">Yakin ingin menghapus data ini?</p>
    <div class="modal-actions">
      <button id="cancelBtn" class="btn secondary">Batal</button>
      <button id="confirmBtn" class="btn danger">Ya, Hapus</button>
    </div>
  </div>
</div>

<script>
// Toast Function
function showToast(type, message) {
    const toast = $('<div class="toast ' + type + '">' + message + '</div>');
    $('#toastContainer').append(toast);
    setTimeout(() => toast.remove(), 3500);
}

$(document).ready(function(){
    let deleteId = null;

    // Konfirmasi hapus nilai
    $(".btnDelete").on("click", function(){
        deleteId = $(this).data("id");
        const mk = $(this).data("mk");

        $("#confirmText").html(`Yakin ingin menghapus nilai mata kuliah <strong>"${mk}"</strong>?<br><small style="color: #6b7280;">Tindakan ini tidak dapat dibatalkan.</small>`);
        $("#confirmModal").fadeIn(200).css("display", "flex");
    });

    // Tombol konfirmasi hapus
    $("#confirmBtn").on("click", function(){
        if (!deleteId) return;

        const btn = $(this);
        btn.prop("disabled", true).text("⏳ Menghapus...");
        $("#cancelBtn").prop("disabled", true);

        $.ajax({
            url: "hapus.php",
            method: "POST",
            data: { id: deleteId },
            dataType: "json",
            success: function(response){
                if (response.status === "success") {
                    showToast("success", response.message);
                    $("#confirmModal").fadeOut(200);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast("error", response.message);
                    $("#confirmModal").fadeOut(200);
                    btn.prop("disabled", false).text("Ya, Hapus");
                    $("#cancelBtn").prop("disabled", false);
                }
            },
            error: function(){
                showToast("error", "Terjadi kesalahan koneksi.");
                $("#confirmModal").fadeOut(200);
                btn.prop("disabled", false).text("Ya, Hapus");
                $("#cancelBtn").prop("disabled", false);
            }
        });
    });

    // Tombol batal
    $("#cancelBtn").on("click", function(){
        $("#confirmModal").fadeOut(200);
        deleteId = null;
    });

    // Tutup modal dengan ESC
    $(document).on("keydown", function(e) {
        if (e.key === "Escape" && $("#confirmModal").is(":visible")) {
            $("#confirmModal").fadeOut(200);
            deleteId = null;
        }
    });

    // Klik di luar modal untuk tutup
    $(document).on("click", ".modal", function(e) {
        if ($(e.target).is(".modal")) {
            $(this).fadeOut(200);
            deleteId = null;
        }
    });
});
</script>

</body>
</html>