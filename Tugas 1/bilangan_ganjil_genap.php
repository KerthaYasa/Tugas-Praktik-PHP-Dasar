<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cek Ganjil Genap</title>
  <link rel="stylesheet" href="style.css">
  <script>
    // Validasi input agar hanya bisa angka (dan minus untuk bilangan negatif)
    function preventInvalidInput(event) {
      const allowedKeys = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab", "Enter"];

      if (event.key === " ") {
        event.preventDefault(); // cegah spasi
      }

      // Cegah input non-angka selain tanda minus di awal
      if (!/[0-9]/.test(event.key) && event.key !== "-" && !allowedKeys.includes(event.key)) {
        event.preventDefault();
      }

      // Hanya boleh ada satu tanda minus di awal
      if (event.key === "-" && event.target.selectionStart !== 0) {
        event.preventDefault();
      }
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Cek Bilangan Ganjil / Genap</h2>

    <!-- Form ke halaman ini sendiri -->
    <form method="POST" action="">
      <input type="text" 
             name="angka" 
             placeholder="Masukkan bilangan bulat" 
             onkeydown="preventInvalidInput(event)" 
             required>
      <input type="submit" value="Cek">
    </form>

    <div class="output">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $angka = $_POST["angka"];

          if (is_numeric($angka)) {
              if ($angka % 2 == 0) {
                  echo "<p>Bilangan <strong>$angka</strong> adalah <span style='color:blue;'>Genap</span></p>";
              } else {
                  echo "<p>Bilangan <strong>$angka</strong> adalah <span style='color:green;'>Ganjil</span></p>";
              }
          } else {
              echo "<p style='color:red;'>Input tidak valid, silakan masukkan angka.</p>";
          }
      }
      ?>
    </div>
  </div>
</body>
</html>
