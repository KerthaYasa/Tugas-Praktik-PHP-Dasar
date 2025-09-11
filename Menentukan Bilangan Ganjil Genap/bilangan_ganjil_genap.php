<?php
$pesan = "";

if (isset($_POST["angka"])) {
    $angka = trim($_POST["angka"]);

    // Validasi input
    if ($angka === "") {
        $pesan = "<span style='color:red;'>Angka tidak boleh kosong!</span>";
    } elseif (!is_numeric($angka)) {
        $pesan = "<span style='color:red;'>Input harus berupa angka!</span>";
    } else {
        $angka = (int)$angka; // ubah ke integer
        if ($angka % 2 == 0) {
            $pesan = "<span style='color:green;'>$angka adalah bilangan GENAP ✅</span>";
        } else {
            $pesan = "<span style='color:blue;'>$angka adalah bilangan GANJIL 🔹</span>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Ganjil / Genap</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
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
            text-align: center;
            width: 350px;
        }
        input[type="text"] {
            width: 90%;
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
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .pesan {
            margin-top: 15px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cek Bilangan Ganjil / Genap</h2>
        <form method="POST" action="">
            <input type="text" name="angka" placeholder="Masukkan Angka" onkeypress="return event.charCode != 32">
            <br>
            <input type="submit" value="Cek">
        </form>

        <div class="pesan"><?php echo $pesan; ?></div>
    </div>
</body>
</html>
