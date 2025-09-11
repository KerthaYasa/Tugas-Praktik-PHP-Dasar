<?php
$nama = "";
$pesan = "";

// Jika tombol submit ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST["nama"]);

    // Validasi
    if ($nama === "") {
        $pesan = "<span style='color:red;'>Nama tidak boleh kosong!</span>";
    } elseif (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
        $pesan = "<span style='color:red;'>Nama hanya boleh huruf dan spasi!</span>";
    } else {
        $pesan = "<span style='color:green;'>Halo, <b>" . htmlspecialchars($nama) . "</b> selamat belajar PHP! 🎉</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Ucapan</title>
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
            text-align: center;
        }
        h2 { color: #333; }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background: #45a049;
        }
        .pesan {
            margin-top: 15px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Ucapan</h2>
        <form method="POST" action="">
            <input type="text" name="nama" placeholder="Masukkan Nama..." value="<?php echo htmlspecialchars($nama); ?>"><br>
            <input type="submit" value="Kirim">
        </form>

        <div class="pesan"><?php echo $pesan; ?></div>
    </div>
</body>
</html>
