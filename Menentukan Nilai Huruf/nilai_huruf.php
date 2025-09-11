<?php
$pesan = "";

if (isset($_POST["nilai"])) {
    $nilai = $_POST["nilai"];
    $nilai = trim($nilai); // hilangkan spasi

    // Validasi input
    if ($nilai === "") {
        $pesan = "<span style='color:red;'>Nilai tidak boleh kosong!</span>";
    } elseif (!is_numeric($nilai)) {
        $pesan = "<span style='color:red;'>Input harus berupa angka!</span>";
    } elseif ($nilai < 0 || $nilai > 100) {
        $pesan = "<span style='color:red;'>Nilai harus antara 0 - 100!</span>";
    } else {
        $nilai = (int)$nilai;

        // Menentukan grade
        if ($nilai >= 85) {
            $grade = "A";
        } elseif ($nilai >= 70) {
            $grade = "B";
        } elseif ($nilai >= 55) {
            $grade = "C";
        } elseif ($nilai >= 40) {
            $grade = "D";
        } else {
            $grade = "E";
        }

        $pesan = "<span style='color:green;'>Nilai Anda: $nilai → Grade: $grade ✔</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cek Nilai Huruf</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
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
        input[type="submit"]:hover { background-color: #45a049; }
        .pesan { margin-top: 15px; font-size: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cek Nilai Huruf</h2>
        <form method="POST" action="">
            <input type="text" name="nilai" placeholder="Masukkan nilai 0-100"
                   onkeypress="return event.charCode != 32">
            <br>
            <input type="submit" value="Cek">
        </form>

        <div class="pesan"><?php echo $pesan; ?></div>
    </div>
</body>
</html>
