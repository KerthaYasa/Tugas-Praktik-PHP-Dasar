<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bilangan Genap</title>
  <style>
    /* Reset dasar */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, Helvetica, sans-serif;
    }

    body {
      background-color: #f5f8fc;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    /* Card */
    .container {
      background: #fff;
      padding: 25px 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 350px;
    }

    .container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    /* Input */
    input[type="number"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 14px;
    }

    /* Tombol */
    button {
      width: 100%;
      background-color: #28a745;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      font-size: 15px;
      cursor: pointer;
      margin-top: 10px;
    }

    button:hover {
      background-color: #218838;
    }

    /* Pesan error */
    .error {
      color: red;
      font-size: 13px;
      margin-top: 10px;
      text-align: center;
    }

    /* Output */
    .output {
      margin-top: 20px;
      padding: 10px;
      background: #f0fff0;
      border-left: 5px solid #28a745;
      border-radius: 5px;
      color: #155724;
      font-size: 14px;
      line-height: 1.5;
    }

    .output b {
      color: #000;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>🔢 Bilangan Genap</h2>
    <form method="POST">
      <label for="n1">Nilai n1:</label>
      <input type="number" name="n1" required>
      <label for="n2">Nilai n2:</label>
      <input type="number" name="n2" required>
      <button type="submit">Tampilkan</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $n1 = (int)$_POST['n1'];
        $n2 = (int)$_POST['n2'];

        if ($n1 < $n2) {
            echo "<div class='output'><b>Bilangan genap dari $n1 sampai $n2:</b><br>";
            for ($i = $n1; $i <= $n2; $i++) {
                if ($i % 2 == 0) {
                    echo $i . " ";
                }
            }
            echo "</div>";
        } else {
            echo "<div class='error'>❌ Syarat salah: n1 harus lebih kecil dari n2</div>";
        }
    }
    ?>
  </div>
</body>
</html>
