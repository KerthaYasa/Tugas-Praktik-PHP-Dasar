<?php
$hasil = "";
$pesan = "";

if (isset($_POST["angka1"]) && isset($_POST["angka2"]) && isset($_POST["operator"])) {
    $angka1 = $_POST["angka1"];
    $angka2 = $_POST["angka2"];
    $operator = $_POST["operator"];

    // Hilangkan spasi di awal & akhir
    $angka1 = trim($angka1);
    $angka2 = trim($angka2);

    // Validasi input
    if ($angka1 === "" || $angka2 === "") {
        $pesan = "Kedua angka harus diisi!";
    } elseif (!is_numeric($angka1) || !is_numeric($angka2)) {
        $pesan = "Input harus berupa angka, tidak boleh huruf atau simbol!";
    } else {
        // Ubah ke number
        $angka1 = (float)$angka1;
        $angka2 = (float)$angka2;

        // Hitung sesuai operator
        switch ($operator) {
            case "tambah":
                $hasil = $angka1 + $angka2;
                break;
            case "kurang":
                $hasil = $angka1 - $angka2;
                break;
            case "kali":
                $hasil = $angka1 * $angka2;
                break;
            case "bagi":
                if ($angka2 == 0) {
                    $pesan = "Tidak bisa membagi dengan nol!";
                } else {
                    $hasil = $angka1 / $angka2;
                }
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Sederhana</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; text-align: center; }
        .container {
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 350px;
        }
        input, select {
            padding: 10px;
            margin: 10px 0;
            width: 90%;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
        }
        input[type="submit"]:hover { background: #45a049; }
        .error { color: red; margin-top: 10px; }
        .hasil { color: green; margin-top: 10px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kalkulator Sederhana</h2>
        <form method="POST" action="">
            <input type="text" name="angka1" placeholder="Angka pertama"
                   onkeypress="return event.charCode != 32">
            <br>
            <input type="text" name="angka2" placeholder="Angka kedua"
                   onkeypress="return event.charCode != 32">
            <br>
            <select name="operator">
                <option value="tambah">Tambah (+)</option>
                <option value="kurang">Kurang (-)</option>
                <option value="kali">Kali (×)</option>
                <option value="bagi">Bagi (÷)</option>
            </select>
            <br>
            <input type="submit" value="Hitung">
        </form>

        <?php if ($pesan != ""): ?>
            <div class="error"><?php echo $pesan; ?></div>
        <?php elseif ($hasil !== ""): ?>
            <div class="hasil">Hasil: <?php echo $hasil; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
