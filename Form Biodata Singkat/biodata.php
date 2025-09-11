<?php
$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama   = trim($_POST["nama"]);
    $umur   = trim($_POST["umur"]);
    $gender = $_POST["gender"] ?? "";
    $alamat = trim($_POST["alamat"]);

    // Validasi Nama
    if ($nama === "") {
        $pesan = "<span style='color:red;'>Nama tidak boleh kosong!</span>";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $pesan = "<span style='color:red;'>Nama hanya boleh huruf dan spasi!</span>";
    }
    // Validasi Umur
    elseif ($umur === "") {
        $pesan = "<span style='color:red;'>Umur tidak boleh kosong!</span>";
    } elseif (!preg_match("/^[0-9]+$/", $umur)) {
        $pesan = "<span style='color:red;'>Umur harus berupa angka tanpa spasi atau simbol!</span>";
    } elseif ((int)$umur <= 0) {
        $pesan = "<span style='color:red;'>Umur harus lebih dari 0!</span>";
    }
    // Validasi Gender
    elseif ($gender === "") {
        $pesan = "<span style='color:red;'>Silakan pilih jenis kelamin!</span>";
    }
    // Validasi Alamat
    elseif ($alamat === "") {
        $pesan = "<span style='color:red;'>Alamat tidak boleh kosong!</span>";
    }
    else {
        // Jika semua valid → tampilkan biodata dengan <b> semua
        $pesan = "<span style='color:green;'>
                    Halo, nama saya <b>" . htmlspecialchars($nama) . "</b>. 
                    Umur saya <b>" . htmlspecialchars($umur) . "</b> tahun. 
                    Saya seorang <b>" . htmlspecialchars($gender) . "</b>. 
                    Saya tinggal di <b>" . htmlspecialchars($alamat) . "</b>.
                  </span>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Biodata Singkat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
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
            width: 400px;
        }
        h2 { text-align: center; color: #333; }
        input, textarea, select {
            width: 95%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        textarea { resize: none; height: 70px; }
        input[type="submit"] {
            background: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
        }
        input[type="submit"]:hover { background: #45a049; }
        .pesan { margin-top: 15px; display: block; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Biodata Singkat</h2>
        <form method="POST" action="">
            <input type="text" name="nama" placeholder="Nama"><br>
            <input type="text" name="umur" placeholder="Umur"
                   onkeypress="return event.charCode != 32"><br> <!-- cegah spasi -->
            <select name="gender">
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select><br>
            <textarea name="alamat" placeholder="Alamat"></textarea><br>
            <input type="submit" value="Kirim">
        </form>

        <div class="pesan"><?php echo $pesan; ?></div>
    </div>
</body>
</html>
