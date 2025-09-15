<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cek Ganjil Genap</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Cek Bilangan Ganjil / Genap</h2>

    <form name="cekForm" onsubmit="cekGanjilGenap(event)">
      <input type="text" 
             name="angka" 
             placeholder="Masukkan bilangan bulat" 
             onkeydown="preventInvalidInput(event)">
      <div id="errAngka" class="error"></div>
      <input type="submit" value="Cek">
    </form>

    <div id="output" class="output"></div>
  </div>

  <script>
    // Cegah input spasi & karakter selain angka dan minus
    function preventInvalidInput(event) {
      const allowedKeys = [
        "Backspace", "Delete", "ArrowLeft", "ArrowRight", "Tab", "Enter"
      ];

      // Jika spasi ditekan → cegah
      if (event.key === " ") {
        event.preventDefault();
      }

      // Jika bukan angka, bukan tanda minus di awal, dan bukan tombol kontrol → cegah
      if (!allowedKeys.includes(event.key)) {
        if (isNaN(event.key) && !(event.key === "-" && event.target.selectionStart === 0)) {
          event.preventDefault();
        }
      }
    }

    // Fungsi cek ganjil/genap
    function cekGanjilGenap(event) {
      event.preventDefault();

      let angka = document.forms["cekForm"]["angka"].value.trim();
      let output = document.getElementById("output");
      let errorDiv = document.getElementById("errAngka");

      // Reset pesan
      errorDiv.innerHTML = "";
      output.innerHTML = "";

      if (angka === "") {
        errorDiv.innerHTML = "Masukkan angka terlebih dahulu!";
        return;
      } else if (isNaN(angka)) {
        errorDiv.innerHTML = "Input hanya boleh angka!";
        return;
      }

      angka = parseInt(angka);

      if (angka % 2 === 0) {
        output.innerHTML = `Angka <b>${angka}</b> adalah <b>Genap</b>.`;
      } else {
        output.innerHTML = `Angka <b>${angka}</b> adalah <b>Ganjil</b>.`;
      }
    }
  </script>
</body>
</html>
