<?php
$hasil = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $menu = $_POST["menu"];
    switch ($menu) {
        case "nasi_goreng":
            $hasil = "<h3>Nasi Goreng</h3>
                      <p>Harga: Rp15.000</p>
                      <img src='https://asset.kompas.com/crops/VcgvggZKE2VHqIAUp1pyHFXXYCs=/202x66:1000x599/1200x800/data/photo/2023/05/07/6456a450d2edd.jpg' width='200'>";
            break;
        case "soto":
            $hasil = "<h3>Soto</h3>
                      <p>Harga: Rp12.000</p>
                      <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTPXF_yl-3hX1YGRNLEES06uJTrkHR3E5NPXw&s' width='200'>";
            break;
        case "mie_ayam":
            $hasil = "<h3>Mie Ayam</h3>
                      <p>Harga: Rp10.000</p>
                      <img src='https://cdn1-production-images-kly.akamaized.net/11f5sUX4bQFnxFB_BllTcFreiPM=/800x450/smart/filters:quality(75):strip_icc():format(webp)/kly-media-production/medias/5290581/original/051540600_1753147274-unnamed__80_.jpg' width='200'>";
            break;
        default:
            $hasil = "<p style='color:red;'>Silakan pilih menu terlebih dahulu!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Menu Makanan</title>
  <link rel="stylesheet" href="style.css">
  <script>
    function validateForm(event) {
      const errMenu = document.getElementById('errMenu');
      errMenu.innerText = ""; // reset

      let menu = document.forms["menuForm"]["menu"].value;
      if (menu === "") {
        errMenu.innerText = "⚠ Silakan pilih menu dulu!";
        event.preventDefault(); // cegah submit
        return false;
      }
      return true;
    }
  </script>
</head>
<body>
  <div class="container">
    <h2>Menu Makanan</h2>
    <form name="menuForm" method="post" onsubmit="return validateForm(event)">
      <select name="menu">
        <option value="">-- Pilih Menu --</option>
        <option value="nasi_goreng">Nasi Goreng</option>
        <option value="soto">Soto</option>
        <option value="mie_ayam">Mie Ayam</option>
      </select>
      <div id="errMenu" class="error"></div>
      <button type="submit">Lihat Harga</button>
    </form>

    <?php if ($hasil): ?>
      <div class="result"><?= $hasil ?></div>
    <?php endif; ?>
  </div>
</body>
</html>