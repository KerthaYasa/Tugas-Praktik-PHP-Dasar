<?php
require_once 'koneksi.php';

// Inisialisasi variabel
$nim = $nama = $prodi = "";
$error = $success = "";

// Saat form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nim   = trim($_POST["nim"]);
    $nama  = trim($_POST["nama"]);
    $prodi = trim($_POST["prodi"]);

    // Validasi form tidak kosong
    if ($nim === "" || $nama === "" || $prodi === "") {
        $error = "Semua field wajib diisi.";
    } else {
        // Cek duplikasi NIM
        $stmt = $conn->prepare("SELECT id FROM mahasiswa WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "NIM sudah terdaftar.";
        } else {
            // Insert data baru
            $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, prodi) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nim, $nama, $prodi);

            if ($stmt->execute()) {
                // Kirim respons JSON jika AJAX
                if (isset($_POST["ajax"])) {
                    echo json_encode(["status" => "success", "message" => "Data mahasiswa berhasil ditambahkan!"]);
                    exit;
                }
                $success = "Data mahasiswa berhasil ditambahkan!";
                // Reset form setelah berhasil
                $nim = $nama = $prodi = "";
            } else {
                $error = "Terjadi kesalahan saat menyimpan data.";
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
    <title>Tambah Mahasiswa</title>
    <link rel="stylesheet" href="assets/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container">
    <h1>➕ Tambah Mahasiswa</h1>

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

    <form method="POST" id="tambahForm" autocomplete="off" class="form-container">
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
                💾 Simpan Data
            </button>
        </div>
    </form>
</div>

<!-- Toast Container -->
<div id="toastContainer"></div>

<!-- Modal Konfirmasi Kembali -->
<div id="confirmBackModal" class="modal">
  <div class="modal-content">
    <h3>⚠️ Konfirmasi</h3>
    <p>Yakin ingin kembali? Data yang sudah diisi akan hilang.</p>
    <div class="modal-actions">
      <button id="cancelBack" class="btn secondary">Batal</button>
      <button id="confirmBackBtn" class="btn danger">Ya, Kembali</button>
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
    let formChanged = false;

    // Track perubahan form
    $("input").on("input", function(){
        formChanged = true;
        $(this).removeClass("input-error");
    });

    // Tombol kembali dengan modal custom
    $("#btnBack").click(function(){
        // Cek apakah ada perubahan di form
        let hasData = false;
        $("input").each(function(){
            if ($(this).val().trim() !== "") {
                hasData = true;
                return false;
            }
        });

        if (hasData) {
            $("#confirmBackModal").fadeIn(200).css("display", "flex");
        } else {
            window.location.href = "index.php";
        }
    });

    // Konfirmasi kembali
    $("#confirmBackBtn").click(function(){
        window.location.href = "index.php";
    });

    // Batal kembali
    $("#cancelBack").click(function(){
        $("#confirmBackModal").fadeOut(200);
    });

    // Klik luar modal = tutup
    $(document).on("click", ".modal", function(e) {
        if ($(e.target).is(".modal")) {
            $(this).fadeOut(200);
        }
    });

    // ESC key untuk tutup modal
    $(document).on("keydown", function(e) {
        if (e.key === "Escape" && $("#confirmBackModal").is(":visible")) {
            $("#confirmBackModal").fadeOut(200);
        }
    });

    // Validasi visual
    $("input[required]").on("blur", function(){
        if ($(this).val().trim() === "") {
            $(this).addClass("input-error");
        } else {
            $(this).removeClass("input-error");
        }
    });

    // Prevent double submit
    $("#tambahForm").on("submit", function(e){
        const submitBtn = $(this).find("button[type=submit]");
        
        // Validasi manual
        let isValid = true;
        $("input[required]").each(function(){
            if ($(this).val().trim() === "") {
                $(this).addClass("input-error");
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            showToast("error", "Mohon lengkapi semua field yang wajib diisi");
            return false;
        }

        submitBtn.prop("disabled", true).text("⏳ Menyimpan...");
    });

    // Warning sebelum leave page jika ada perubahan
    $(window).on("beforeunload", function(e){
        if (formChanged) {
            return "Data yang sudah diisi akan hilang. Yakin ingin meninggalkan halaman?";
        }
    });

    // Disable warning setelah submit
    $("#tambahForm").on("submit", function(){
        formChanged = false;
    });
});
</script>

</body>
</html>