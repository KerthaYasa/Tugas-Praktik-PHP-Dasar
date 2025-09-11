<?php
$pesan = "";

if (isset($_POST["menu"])) {
    $menu = $_POST["menu"];

    // Cek apakah kosong
    if ($menu === "") {
        $pesan = "<span style='color:red;'>Silakan pilih menu terlebih dahulu!</span>";
    } else {
        // Tentukan harga dengan switch-case
        switch ($menu) {
            case "nasi_goreng":
                $harga = 20000;
                $namaMenu = "Nasi Goreng";
                break;
            case "soto":
                $harga = 15000;
                $namaMenu = "Soto";
                break;
            case "mie_ayam":
                $harga = 18000;
                $namaMenu = "Mie Ayam";
                break;
            default:
                $harga = 0;
                $namaMenu = "";
        }

        if ($harga > 0) {
            $pesan = "<span style='color:green;'>Anda memilih $namaMenu → Harga: Rp " . number_format($harga, 0, ',', '.') . "</span>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Menu Makanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }
        h2 { color: #333; }
        select {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover { background-color: #45a049; }
        .pesan { margin-top: 15px; font-size: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pilih Menu Makanan</h2>
        <form method="POST" action="">
            <select name="menu">
                <option value="">-- Pilih Menu --</option>
                <option value="nasi_goreng">Nasi Goreng</option>
                <option value="soto">Soto</option>
                <option value="mie_ayam">Mie Ayam</option>
            </select>
            <br>
            <input type="submit" value="Lihat Harga">
        </form>

        <div class="pesan"><?php echo $pesan; ?></div>
    </div>
</body>
</html>
