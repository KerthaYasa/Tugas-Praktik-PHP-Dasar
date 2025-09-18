<?php
$mahasiswa = [
    ["nim" => "2405551001", "nama" => "I Komang Cahya Kertha Yasa", "umur" => 20, "prodi" => "Teknologi Informasi"],
    ["nim" => "2405551002", "nama" => "Made Arya Pradnyana", "umur" => 19, "prodi" => "Teknologi Informasi"],
    ["nim" => "2405551003", "nama" => "Ni Luh Putu Maharani", "umur" => 18, "prodi" => "Teknologi Informasi"],
    ["nim" => "2405551004", "nama" => "Kadek Adi Saputra", "umur" => 21, "prodi" => "Teknologi Informasi"],
    ["nim" => "2405551005", "nama" => "Gede Surya Dharma", "umur" => 20, "prodi" => "Teknologi Informasi"],
    ["nim" => "2405551006", "nama" => "Putu Ayu Prameswari", "umur" => 19, "prodi" => "Teknologi Informasi"],
    ["nim" => "2405551007", "nama" => "Made Santika Putra", "umur" => 18, "prodi" => "Teknologi Informasi"],
    ["nim" => "2405551008", "nama" => "Komang Dwi Anggara", "umur" => 20, "prodi" => "Teknologi Informasi"],
    ["nim" => "2405551009", "nama" => "Ni Kadek Sri Utami", "umur" => 19, "prodi" => "Teknologi Informasi"],
    ["nim" => "2405551010", "nama" => "Gusti Ayu Cahya Dewi", "umur" => 18, "prodi" => "Teknologi Informasi"]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Mahasiswa</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f8fc; margin: 30px; text-align: center; }
    table { border-collapse: collapse; margin: 20px auto; width: 80%; background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background: #e6f0ff; }
    tr:nth-child(even) { background: #f9f9f9; }
    h2 { color: darkblue; }
    /* Biar isi kolom Nama rata kiri */
    td:nth-child(3) {
      text-align: left;
      padding-left: 15px;
    }
    /* Header Nama tetap center */
    th:nth-child(3) {
      text-align: center;
    }
  </style>
</head>
<body>
  <h2>👨‍🎓 Data Mahasiswa</h2>
  <table>
    <tr>
      <th>No</th>
      <th>NIM</th>
      <th>Nama</th>
      <th>Umur</th>
      <th>Program Studi</th>
    </tr>
    <?php
    $no = 1;
    foreach ($mahasiswa as $mhs) {
        echo "<tr>
                <td>$no</td>
                <td>{$mhs['nim']}</td>
                <td>{$mhs['nama']}</td>
                <td>{$mhs['umur']}</td>
                <td>{$mhs['prodi']}</td>
              </tr>";
        $no++;
    }
    ?>
  </table>
</body>
</html>
