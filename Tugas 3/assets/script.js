/* ======================================
   SCRIPT UTAMA - INTERAKSI & ANIMASI UX
   ====================================== */

// ==============================
// Fungsi Toast Notification
// ==============================
function showToast(type = "info", message = "Pesan notifikasi") {
  const toastContainer = document.getElementById("toastContainer");
  if (!toastContainer) return;

  const toast = document.createElement("div");
  toast.classList.add("toast");
  if (type === "success") toast.classList.add("success");
  if (type === "error") toast.classList.add("error");
  toast.innerText = message;

  toastContainer.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = "0";
    toast.style.transform = "translateX(50px)";
    setTimeout(() => toast.remove(), 400);
  }, 3000);
}

// ==============================
// Efek & Logika Modal Konfirmasi
// ==============================
$(document).ready(function() {

  // Tutup modal jika klik area luar konten
  $(document).on("click", ".modal", function(e) {
    if ($(e.target).is(".modal")) {
      $(this).fadeOut(200);
    }
  });

  // Hilangkan alert otomatis
  $(".alert").each(function() {
    const el = $(this);
    setTimeout(() => el.fadeOut(400, () => el.remove()), 4000);
  });

  // Validasi input realtime
  $("input[required], select[required]").on("input change", function() {
    if ($(this).val().trim() === "") $(this).addClass("invalid");
    else $(this).removeClass("invalid");
  });

  // ==============================
  // Universal Modal Hapus Handler
  // ==============================
  $(document).on("click", ".btnDelete", function() {
    const id = $(this).data("id");
    const nama = $(this).data("nama") || $(this).data("mk") || "data ini";

    $("#confirmText").text(`Yakin ingin menghapus ${nama ? "'" + nama + "'" : "data ini"}?`);
    $("#confirmModal").fadeIn(200);

    // Jika tombol Hapus ditekan
    $("#confirmBtn").off().on("click", function() {
      const file = window.location.pathname.includes("nilai") ? "hapus.php" : "hapus.php";
      $.post(file, { id: id }, function(response) {
        showToast(response.status, response.message);
        if (response.status === "success") setTimeout(() => location.reload(), 1200);
      }, "json");
      $("#confirmModal").fadeOut(200);
    });

    // Jika tombol Batal ditekan
    $("#cancelBtn").off().on("click", function() {
      $("#confirmModal").fadeOut(200);
    });
  });
});

// ==============================
// Utilitas AJAX Umum
// ==============================
function postData(url, data, onSuccess, onError) {
  $.ajax({
    url: url,
    type: "POST",
    data: data,
    dataType: "json",
    success: function(response) {
      if (response.status === "success") {
        showToast("success", response.message);
        if (typeof onSuccess === "function") onSuccess(response);
      } else {
        showToast("error", response.message);
        if (typeof onError === "function") onError(response);
      }
    },
    error: function() {
      showToast("error", "Terjadi kesalahan koneksi server.");
    }
  });
}
