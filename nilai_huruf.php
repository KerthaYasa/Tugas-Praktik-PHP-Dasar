<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Konversi Nilai Huruf</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Konversi Nilai Angka ke Nilai Huruf</h2>

    <form name="nilaiForm" onsubmit="cekNilaiHuruf(event)">
      <input type="text" 
             name="nilai" 
             placeholder="Masukkan nilai (0 - 100)" 
             onkeydown="preventInvalidInput(event)">
      <div id="errNilai" class="error"></div>
      <input type="submit" value="Konversi">
    </form>

    <div id="output" class="output"></div>
  </div>

  <script>
    // Cegah input spasi & karakter selain angka
    function preventInvalidInput(event) {
      const allowedKeys = [
        "Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab", "Enter"
      ];

      if (event.key === " ") {
        event.preventDefault();
      }

      if (!allowedKeys.includes(event.key)) {
        if (isNaN(event.key)) {
          event.preventDefault();
        }
      }
    }

    // Fungsi konversi nilai huruf
    function cekNilaiHuruf(event) {
      event.preventDefault();

      let nilai = document.forms["nilaiForm"]["nilai"].value.trim();
      let output = document.getElementById("output");
      let errorDiv = document.getElementById("errNilai");

      errorDiv.innerHTML = "";
      output.innerHTML = "";

      if (nilai === "") {
        errorDiv.innerHTML = "Masukkan nilai terlebih dahulu!";
        return;
      } else if (isNaN(nilai)) {
        errorDiv.innerHTML = "Input hanya boleh angka!";
        return;
      }

      nilai = parseInt(nilai);

      if (nilai < 0 || nilai > 100) {
        errorDiv.innerHTML = "Nilai harus di antara 0 - 100!";
        return;
      }

      let huruf = "";

      if (nilai >= 85) huruf = "A";
      else if (nilai >= 70) huruf = "B";
      else if (nilai >= 55) huruf = "C";
      else if (nilai >= 40) huruf = "D";
      else huruf = "E";

      output.innerHTML = `Nilai <b>${nilai}</b> dikonversi menjadi <b>${huruf}</b>.`;
    }
  </script>
</body>
</html>
