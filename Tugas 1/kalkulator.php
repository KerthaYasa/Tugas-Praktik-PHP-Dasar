<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kalkulator Sederhana</title>
  <link rel="stylesheet" href="style.css">
  <script>
 
    function validateCalc() {
      let angka1 = document.forms["calcForm"]["angka1"].value.trim();
      let angka2 = document.forms["calcForm"]["angka2"].value.trim();
      let operator = document.forms["calcForm"]["operator"].value;

      let numPattern = /^-?\d+(\.\d+)?$/; // angka bulat/pecahan (positif/negatif)

      document.querySelectorAll(".error").forEach(e => e.innerHTML = "");

      let valid = true;

      if (angka1 === "") {
        document.getElementById("errAngka1").innerHTML = "Angka pertama harus diisi!";
        valid = false;
      } else if (!numPattern.test(angka1)) {
        document.getElementById("errAngka1").innerHTML = "Input hanya boleh angka!";
        valid = false;
      }

      if (angka2 === "") {
        document.getElementById("errAngka2").innerHTML = "Angka kedua harus diisi!";
        valid = false;
      } else if (!numPattern.test(angka2)) {
        document.getElementById("errAngka2").innerHTML = "Input hanya boleh angka!";
        valid = false;
      } else if (operator === "/" && parseFloat(angka2) === 0) {
        document.getElementById("errAngka2").innerHTML = "Tidak bisa dibagi dengan nol!";
        valid = false;
      }

      return valid;
    }

    function preventSpace(event) {
      if (event.key === " ") {
        event.preventDefault();
      }
    }

    // Pasang event listener setelah halaman load
    window.onload = function() {
      document.forms["calcForm"]["angka1"].addEventListener("keydown", preventSpace);
      document.forms["calcForm"]["angka2"].addEventListener("keydown", preventSpace);
    }
  </script>

</head>
<body>
  <div class="container">
    <h2>Kalkulator Sederhana</h2>
    <form name="calcForm" method="post" onsubmit="return validateCalc()">
      <input type="text" name="angka1" placeholder="Masukkan Angka Pertama" 
             value="<?= isset($_POST['angka1']) ? htmlspecialchars($_POST['angka1']) : '' ?>">
      <div id="errAngka1" class="error"></div>

      <input type="text" name="angka2" placeholder="Masukkan Angka Kedua" 
             value="<?= isset($_POST['angka2']) ? htmlspecialchars($_POST['angka2']) : '' ?>">
      <div id="errAngka2" class="error"></div>

      <select name="operator">
        <option value="">-- Pilih Operator --</option>
        <option value="+" <?= (isset($_POST['operator']) && $_POST['operator'] == "+") ? "selected" : "" ?>>+</option>
        <option value="-" <?= (isset($_POST['operator']) && $_POST['operator'] == "-") ? "selected" : "" ?>>-</option>
        <option value="*" <?= (isset($_POST['operator']) && $_POST['operator'] == "*") ? "selected" : "" ?>>×</option>
        <option value="/" <?= (isset($_POST['operator']) && $_POST['operator'] == "/") ? "selected" : "" ?>>÷</option>
      </select>
      <div id="errOperator" class="error"></div>

      <input type="submit" value="Hitung">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $angka1 = $_POST["angka1"];
      $angka2 = $_POST["angka2"];
      $operator = $_POST["operator"];
      $hasil = "";

      if (is_numeric($angka1) && is_numeric($angka2) && $operator != "") {
        switch ($operator) {
          case "+": $hasil = $angka1 + $angka2; break;
          case "-": $hasil = $angka1 - $angka2; break;
          case "*": $hasil = $angka1 * $angka2; break;
          case "/": 
            if ($angka2 == 0) {
              $hasil = "Tidak bisa dibagi dengan nol!";
            } else {
              $hasil = $angka1 / $angka2;
            }
            break;
        }
        echo "<div class='output'>
                Hasil dari <b>$angka1 $operator $angka2</b> adalah: 
                <b>$hasil</b>
              </div>";
      }
    }
    ?>

  </div>
</body>
</html>
