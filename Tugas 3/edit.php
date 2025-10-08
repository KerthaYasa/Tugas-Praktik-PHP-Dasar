<?php
require_once 'koneksi.php';

// Pastikan parameter id ada
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET["id"]);
$error = $success = "";

// Ambil data mahasiswa berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("<div class='container'><h1>❌ Data Tidak Ditemukan</h1><p>Data mahasiswa yang Anda cari tidak ditemukan.</p><a href='index.php' class='btn primary'>← Kembali ke Beranda</a></div>");
}
$data = $result->fetch_assoc();
$stmt->close();

$nim = $data["nim"];
$nama = $data["nama"];
$prodi = $data["prodi"];

// Saat form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nim   = trim($_POST["nim"]);
    $nama  = trim($_POST["nama"]);
    $prodi = trim($_POST["prodi"]);

    if ($nim === "" || $nama === "" || $prodi === "") {
        $error = "Semua field wajib diisi.";
    } else {
        // Cek apakah NIM digunakan mahasiswa lain
        $stmt = $conn->prepare("SELECT id FROM mahasiswa WHERE nim = ? AND id != ?");
        $stmt->bind_param("si", $nim, $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $error = "NIM sudah digunakan oleh mahasiswa lain.";
        } else {
            // Update data
            $stmt = $conn->prepare("UPDATE mahasiswa SET nim=?, nama=?, prodi=? WHERE id=?");
            $stmt->bind_param("sssi", $nim, $nama, $prodi, $id);
            if ($stmt->execute()) {
                $success = "Data mahasiswa berhasil diperbarui!";
            } else {
                $error = "Terjadi kesalahan saat menyimpan perubahan.";
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container">
    <h1>✏️ Edit Mahasiswa</h1>

    <?php if ($error): ?>
        <div class="alert error">
            <strong>⚠️ Error!</strong> <?= htmlspecialchars($error); ?>
        </div>
    <?php elseif ($success): ?>
        <div class="alert success">
            <strong>✅ Berhasil!</strong> <?= htmlspecialchars($success); ?>
        </div>
        <script>
            setTimeout(() => window.location.href = "index.php", 1500);
        </script>
    <?php endif; ?>

    <form method="POST" autocomplete="off" class="form-container">
        <div class="form-group">
            <label for="nim">NIM <span class="required">*</span></label>
            <input type="text" 
                   id="nim" 
                   name="nim" 
                   value="<?= htmlspecialchars($nim); ?>" 
                   placeholder="Masukkan NIM mahasiswa"
                   required>
        </div>

        <div class="form-group">
            <label for="nama">Nama Lengkap <span class="required">*</span></label>
            <input type="text" 
                   id="nama" 
                   name="nama" 
                   value="<?= htmlspecialchars($nama); ?>" 
                   placeholder="Masukkan nama lengkap"
                   required>
        </div>

        <div class="form-group">
            <label for="prodi">Program Studi <span class="required">*</span></label>
            <input type="text" 
                   id="prodi" 
                   name="prodi" 
                   value="<?= htmlspecialchars($prodi); ?>" 
                   placeholder="Masukkan program studi"
                   required>
        </div>

        <div class="form-actions">
            <button type="button" class="btn secondary" id="btnBack">
                ← Kembali
            </button>
            <button type="submit" class="btn primary">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
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

$(document).ready(function(){
    // Tombol kembali
    $("#btnBack").click(function(){
        if (confirm("Yakin ingin kembali? Perubahan yang belum disimpan akan hilang.")) {
            window.location.href = "index.php";
        }
    });

    // Validasi visual sederhana
    $("input[required]").on("blur", function(){
        if ($(this).val().trim() === "") {
            $(this).addClass("input-error");
        } else {
            $(this).removeClass("input-error");
        }
    });

    // Hapus error state saat user mulai mengetik
    $("input").on("input", function(){
        $(this).removeClass("input-error");
    });

    // Prevent double submit
    $("form").on("submit", function(){
        $(this).find("button[type=submit]").prop("disabled", true).text("⏳ Menyimpan...");
    });
});
</script>

</body>
</html>