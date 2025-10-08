<?php
require_once '../koneksi.php';

if (!isset($_GET["mahasiswa_id"]) || !isset($_GET["return"])) {
    header("Location: ../index.php");
    exit;
}

$mahasiswa_id = intval($_GET["mahasiswa_id"]);
$return = $_GET["return"];

// Ambil data mahasiswa
$stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
$stmt->bind_param("i", $mahasiswa_id);
$stmt->execute();
$mhs = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$mhs) {
    die("<div class='container'><h1>❌ Data Tidak Ditemukan</h1><p>Mahasiswa yang Anda cari tidak ditemukan.</p><a href='../index.php' class='btn primary'>← Kembali ke Beranda</a></div>");
}

$mata_kuliah = $sks = $nilai_huruf = $nilai_angka = "";
$error = $success = "";

// Saat form disubmit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mata_kuliah = trim($_POST["mata_kuliah"]);
    $sks = intval($_POST["sks"]);
    $nilai_huruf = trim($_POST["nilai_huruf"]);
    $nilai_angka = floatval($_POST["nilai_angka"]);

    if ($mata_kuliah === "" || $sks <= 0 || $nilai_huruf === "" || $nilai_angka < 0) {
        $error = "Semua field wajib diisi dengan benar.";
    } else {
        // Cek duplikasi mata kuliah untuk mahasiswa ini
        $stmt = $conn->prepare("SELECT id FROM nilai WHERE mahasiswa_id = ? AND mata_kuliah = ?");
        $stmt->bind_param("is", $mahasiswa_id, $mata_kuliah);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $error = "Mata kuliah ini sudah terdaftar untuk mahasiswa tersebut.";
        } else {
            $stmt = $conn->prepare("INSERT INTO nilai (mahasiswa_id, mata_kuliah, sks, nilai_huruf, nilai_angka) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isisd", $mahasiswa_id, $mata_kuliah, $sks, $nilai_huruf, $nilai_angka);
            if ($stmt->execute()) {
                $success = "Nilai berhasil ditambahkan!";
                // Reset form
                $mata_kuliah = $sks = $nilai_huruf = $nilai_angka = "";
            } else {
                $error = "Gagal menambahkan data nilai.";
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
    <title>Tambah Nilai - <?= htmlspecialchars($mhs['nama']); ?></title>
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>

<div class="container">
    <h1>➕ Tambah Nilai Mahasiswa</h1>

    <!-- Profil Mahasiswa -->
    <div class="card profile">
        <h2>👤 <?= htmlspecialchars($mhs['nama']); ?></h2>
        <p><strong>NIM:</strong> <?= htmlspecialchars($mhs['nim']); ?></p>
        <p><strong>Program Studi:</strong> <?= htmlspecialchars($mhs['prodi']); ?></p>
    </div>

    <?php if ($error): ?>
        <div class="alert error">
            <strong>⚠️ Error!</strong> <?= htmlspecialchars($error); ?>
        </div>
    <?php elseif ($success): ?>
        <div class="alert success">
            <strong>✅ Berhasil!</strong> <?= htmlspecialchars($success); ?>
        </div>
        <script>
            setTimeout(() => {
                <?php if ($return === "main"): ?>
                    window.location.href = "../index.php";
                <?php else: ?>
                    window.location.href = "index.php?mahasiswa_id=<?= $mahasiswa_id; ?>";
                <?php endif; ?>
            }, 1500);
        </script>
    <?php endif; ?>

    <form method="POST" autocomplete="off" class="form-container" id="nilaiForm">
        <div class="form-group">
            <label for="mata_kuliah">Mata Kuliah <span class="required">*</span></label>
            <input type="text" 
                   id="mata_kuliah" 
                   name="mata_kuliah" 
                   value="<?= htmlspecialchars($mata_kuliah); ?>" 
                   placeholder="Contoh: Pemrograman Web"
                   required>
        </div>

        <div class="form-group">
            <label for="sks">SKS <span class="required">*</span></label>
            <input type="number" 
                   id="sks" 
                   name="sks" 
                   value="<?= htmlspecialchars($sks); ?>" 
                   min="1" 
                   max="6" 
                   placeholder="1-6"
                   required>
            <small style="color: #6b7280; font-size: 13px;">Jumlah SKS antara 1-6</small>
        </div>

        <div class="form-group">
            <label for="nilai_huruf">Nilai Huruf <span class="required">*</span></label>
            <select name="nilai_huruf" id="nilai_huruf" required>
                <option value="">-- Pilih Nilai --</option>
                <?php
                $huruf = [
                    'A' => 'A (4.00 - Sangat Baik)', 
                    'B' => 'B (3.00 - Baik)', 
                    'C' => 'C (2.00 - Cukup)', 
                    'D' => 'D (1.00 - Kurang)', 
                    'E' => 'E (0.00 - Gagal)'
                ];
                foreach ($huruf as $key => $label) {
                    $selected = ($nilai_huruf == $key) ? "selected" : "";
                    echo "<option value='$key' $selected>$label</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nilai_angka">Nilai Angka (Skala 4.00) <span class="required">*</span></label>
            <input type="number" 
                   id="nilai_angka" 
                   name="nilai_angka" 
                   value="<?= htmlspecialchars($nilai_angka); ?>" 
                   min="0" 
                   max="4" 
                   step="0.01"
                   placeholder="0.00 - 4.00"
                   readonly
                   style="background-color: #f3f4f6; cursor: not-allowed;"
                   required>
            <small style="color: #6b7280; font-size: 13px;">Nilai akan terisi otomatis saat memilih nilai huruf</small>
        </div>

        <div class="form-actions">
            <button type="button" class="btn secondary" id="btnBack">
                ← Kembali
            </button>
            <button type="submit" class="btn primary">
                💾 Simpan Nilai
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
    $("input:not([readonly]), select").on("input change", function(){
        formChanged = true;
        $(this).removeClass("input-error");
    });

    // Tombol kembali dengan modal custom
    $("#btnBack").click(function(){
        // Cek apakah ada perubahan di form
        let hasData = false;
        $("#mata_kuliah, #sks").each(function(){
            if ($(this).val().trim() !== "") {
                hasData = true;
                return false;
            }
        });
        if ($("#nilai_huruf").val() !== "") {
            hasData = true;
        }

        if (hasData) {
            $("#confirmBackModal").fadeIn(200).css("display", "flex");
        } else {
            redirectBack();
        }
    });

    // Fungsi redirect
    function redirectBack() {
        <?php if ($return === "main"): ?>
            window.location.href = "../index.php";
        <?php else: ?>
            window.location.href = "index.php?mahasiswa_id=<?= $mahasiswa_id; ?>";
        <?php endif; ?>
    }

    // Konfirmasi kembali
    $("#confirmBackBtn").click(function(){
        redirectBack();
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

    // Auto isi nilai angka berdasarkan huruf (SKALA 4.00)
    $("#nilai_huruf").on("change", function(){
        const huruf = $(this).val();
        const mapping = { 
            "A": 4.00, 
            "B": 3.00, 
            "C": 2.00, 
            "D": 1.00, 
            "E": 0.00 
        };
        if (mapping[huruf] !== undefined) {
            $("#nilai_angka").val(mapping[huruf].toFixed(2));
            showToast("success", "Nilai angka otomatis diisi: " + mapping[huruf].toFixed(2));
        }
    });

    // Validasi visual
    $("input[required]:not([readonly]), select[required]").on("blur", function(){
        if ($(this).val().trim() === "" || $(this).val() === null) {
            $(this).addClass("input-error");
        } else {
            $(this).removeClass("input-error");
        }
    });

    // Validasi range SKS
    $("#sks").on("input", function(){
        const val = parseInt($(this).val());
        if (val < 1 || val > 6) {
            $(this).addClass("input-error");
            showToast("error", "SKS harus antara 1-6");
        } else {
            $(this).removeClass("input-error");
        }
    });

    // Prevent double submit
    $("#nilaiForm").on("submit", function(e){
        const submitBtn = $(this).find("button[type=submit]");
        
        // Validasi manual
        let isValid = true;
        $("input[required]:not([readonly]), select[required]").each(function(){
            if ($(this).val().trim() === "" || $(this).val() === null) {
                $(this).addClass("input-error");
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            showToast("error", "Mohon lengkapi semua field yang wajib diisi");
            return false;
        }

        // Validasi range
        const sks = parseInt($("#sks").val());
        const nilaiAngka = parseFloat($("#nilai_angka").val());
        
        if (sks < 1 || sks > 6) {
            e.preventDefault();
            $("#sks").addClass("input-error");
            showToast("error", "SKS harus antara 1-6");
            return false;
        }

        if (nilaiAngka < 0 || nilaiAngka > 4) {
            e.preventDefault();
            showToast("error", "Nilai angka harus antara 0.00 - 4.00");
            return false;
        }

        submitBtn.prop("disabled", true).text("⏳ Menyimpan...");
        formChanged = false; // Disable warning
    });

    // Warning sebelum leave page
    $(window).on("beforeunload", function(e){
        if (formChanged) {
            return "Data yang sudah diisi akan hilang. Yakin ingin meninggalkan halaman?";
        }
    });
});
</script>

</body>
</html>