<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Biodata Singkat</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function validateForm() {
      let nama = document.forms["biodataForm"]["nama"].value.trim();
      let umur = document.forms["biodataForm"]["umur"].value.trim();
      let gender = document.forms["biodataForm"]["gender"].value;
      let alamat = document.forms["biodataForm"]["alamat"].value.trim();

      let namaPattern = /^[A-Za-z\s]+$/; // hanya huruf & spasi
      let umurPattern = /^[0-9]+$/; // hanya angka bulat positif

      // Reset pesan error
      document.querySelectorAll(".error").forEach(e => e.innerHTML = "");

      let valid = true;

      if (nama === "") {
        document.getElementById("errNama").innerHTML = "Nama harus diisi!";
        valid = false;
      } else if (!namaPattern.test(nama)) {
        document.getElementById("errNama").innerHTML = "Nama hanya boleh huruf dan spasi!";
        valid = false;
      }

      if (umur === "") {
        document.getElementById("errUmur").innerHTML = "Umur harus diisi!";
        valid = false;
      } else if (!umurPattern.test(umur)) {
        document.getElementById("errUmur").innerHTML = "Umur harus angka bulat positif!";
        valid = false;
      } else if (parseInt(umur) <= 0) {
        document.getElementById("errUmur").innerHTML = "Umur tidak boleh nol atau negatif!";
        valid = false;
      }

      if (gender === "") {
        document.getElementById("errGender").innerHTML = "Pilih jenis kelamin!";
        valid = false;
      }

      if (alamat === "") {
        document.getElementById("errAlamat").innerHTML = "Alamat harus diisi!";
        valid = false;
      } else if (alamat.length < 5) {
        document.getElementById("errAlamat").innerHTML = "Alamat minimal 5 karakter!";
        valid = false;
      }

      return valid;
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Form Biodata Singkat</h2>
    <form name="biodataForm" method="post" onsubmit="return validateForm()">
      <input type="text" name="nama" placeholder="Nama">
      <div id="errNama" class="error"></div>

      <input type="text" name="umur" placeholder="Umur">
      <div id="errUmur" class="error"></div>

      <select name="gender">
        <option value="">-- Pilih Jenis Kelamin --</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>
      <div id="errGender" class="error"></div>

      <textarea name="alamat" placeholder="Alamat"></textarea>
      <div id="errAlamat" class="error"></div>

      <input type="submit" value="Kirim">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $nama = htmlspecialchars($_POST["nama"]);
      $umur = htmlspecialchars($_POST["umur"]);
      $gender = htmlspecialchars($_POST["gender"]);
      $alamat = htmlspecialchars($_POST["alamat"]);

      echo "<div class='output'>
              Halo, nama saya <b>$nama</b>. 
              Umur saya <b>$umur</b> tahun. 
              Saya seorang <b>$gender</b>. 
              Saya tinggal di <b>$alamat</b>.
            </div>";
    }
    ?>
  </div>
</body>
</html>
