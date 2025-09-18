<?php
$hargaHP = [
    "iPhone 15 Pro Max" => 20000000,
    "Samsung Galaxy S24 Ultra" => 19000000,
    "Xiaomi 14 Pro" => 15000000,
    "Oppo Find X6 Pro" => 16000000,
    "Vivo X90 Pro" => 14000000,
    "Realme GT 5 Pro" => 12000000,
    "Asus ROG Phone 7" => 18000000,
    "Google Pixel 8 Pro" => 17000000,
    "OnePlus 11" => 13000000,
    "Infinix Zero Ultra" => 9000000
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Harga HP</title>
  <style>
    body {
      display: flex;
      flex-direction: column;   /* susun vertikal (judul di atas tabel) */
      align-items: center;      /* rata tengah horizontal */
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 20px;
    }
    h3 {
      color: darkblue;
      margin-bottom: 15px;
    }
    table {
      border-collapse: collapse;
      width: 70%;
      background: white;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
    }
    th {
      background: #e6f0ff;
      text-align: center;
    }
    td:nth-child(1) { text-align: center; }
    td:nth-child(3) { text-align: right; font-weight: bold; }
    tr:nth-child(even) { background: #f2f2f2; }
  </style>
</head>
<body>
  <h3>📱 Daftar Harga HP</h3>
  <table>
    <tr>
      <th>No</th>
      <th>Nama HP</th>
      <th>Harga</th>
    </tr>
    <?php
    $no = 1;
    foreach ($hargaHP as $hp => $harga) {
        echo "<tr>
                <td>$no</td>
                <td>$hp</td>
                <td>Rp " . number_format($harga, 0, ',', '.') . "</td>
              </tr>";
        $no++;
    }
    ?>
  </table>
</body>
</html>
