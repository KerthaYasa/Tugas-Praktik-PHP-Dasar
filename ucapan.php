<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Ucapan</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function validateForm() {
      let nama = document.forms["ucapanForm"]["nama"].value.trim();
      let namaPattern = /^[A-Za-z\s]+$/; // hanya huruf & spasi
      document.getElementById("errNama").innerHTML = "";

      if (nama === "") {
        document.getElementById("errNama").innerHTML = "Nama harus diisi!";
        return false;
      } else if (!namaPattern.test(nama)) {
        document.getElementById("errNama").innerHTML = "Nama hanya boleh huruf dan spasi!";
        return false;
      }
      return true;
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Form Ucapan</h2>
    <form name="ucapanForm" method="post" onsubmit="return validateForm()">
      <input type="text" name="nama" placeholder="Masukkan Nama">
      <div id="errNama" class="error"></div>

      <input type="submit" value="Kirim">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nama = htmlspecialchars($_POST["nama"]);
      echo "<div class='output'>Halo, <b>$nama</b> selamat belajar PHP!</div>";
    }
    ?>
  </div>
</body>
</html>
