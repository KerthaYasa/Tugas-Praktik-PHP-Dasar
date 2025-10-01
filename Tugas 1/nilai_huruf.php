<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Konversi Nilai Huruf</title>
  <link rel="stylesheet" href="style.css">
  <script>
    // Validasi input: hanya boleh angka + titik desimal
    function preventInvalidInput(event) {
      const allowedKeys = ["Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab", "Enter", "."];

      if (event.key === " ") {
        event.preventDefault(); // cegah spasi
      }

      // Cegah input non-angka dan selain titik
      if (!allowedKeys.includes(event.key) && isNaN(event.key)) {
        event.preventDefault();
      }
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Konversi Nilai Angka ke Nilai Huruf</h2>

    <!-- Form kirim ke halaman ini -->
    <form method="POST" action="">
      <input type="number" 
             name="nilai" 
             placeholder="Masukkan nilai (0 - 100)" 
             min="0" 
             max="100" 
             step="0.01" 
             required>
      <input type="submit" value="Konversi">
    </form>

    <div class="output">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $nilai = $_POST["nilai"];

          if (is_numeric($nilai) && $nilai >= 0 && $nilai <= 100) {
              if ($nilai >= 85) {
                  $huruf = "A";
              } elseif ($nilai >= 70) {
                  $huruf = "B";
              } elseif ($nilai >= 55) {
                  $huruf = "C";
              } elseif ($nilai >= 40) {
                  $huruf = "D";
              } else {
                  $huruf = "E";
              }

              echo "<p>Nilai angka: <strong>$nilai</strong> <br> 
                    Konversi ke huruf: <strong style='color:blue;'>$huruf</strong></p>";
          } else {
              echo "<p style='color:red;'>Masukkan angka antara 0 - 100!</p>";
          }
      }
      ?>
    </div>
  </div>
</body>
</html>
