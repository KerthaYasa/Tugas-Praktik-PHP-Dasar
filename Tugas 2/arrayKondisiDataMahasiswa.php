<?php
$mahasiswa = [
    ["nim" => "2405551001", "nama" => "I Komang Cahya Kertha Yasa", "umur" => 20, "prodi" => "Teknologi Informasi", "nilai" => 85],
    ["nim" => "2405551002", "nama" => "Made Arya Pradnyana", "umur" => 19, "prodi" => "Teknologi Informasi", "nilai" => 68],
    ["nim" => "2405551003", "nama" => "Ni Luh Putu Maharani", "umur" => 18, "prodi" => "Teknologi Informasi", "nilai" => 90],
    ["nim" => "2405551004", "nama" => "Kadek Adi Saputra", "umur" => 21, "prodi" => "Teknologi Informasi", "nilai" => 55],
    ["nim" => "2405551005", "nama" => "Gede Surya Dharma", "umur" => 20, "prodi" => "Teknologi Informasi", "nilai" => 72],
    ["nim" => "2405551006", "nama" => "Putu Ayu Prameswari", "umur" => 19, "prodi" => "Teknologi Informasi", "nilai" => 60],
    ["nim" => "2405551007", "nama" => "Made Santika Putra", "umur" => 18, "prodi" => "Teknologi Informasi", "nilai" => 95],
    ["nim" => "2405551008", "nama" => "Komang Dwi Anggara", "umur" => 20, "prodi" => "Teknologi Informasi", "nilai" => 78],
    ["nim" => "2405551009", "nama" => "Ni Kadek Sri Utami", "umur" => 19, "prodi" => "Teknologi Informasi", "nilai" => 65],
    ["nim" => "2405551010", "nama" => "Gusti Ayu Cahya Dewi", "umur" => 18, "prodi" => "Teknologi Informasi", "nilai" => 88]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Mahasiswa + Nilai</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f5f8fc; margin: 30px; text-align: center; }
    table { border-collapse: collapse; margin: 20px auto; width: 90%; background: white; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    th, td { border: 1px solid #ccc; padding: 10px; }
    th { background: #e6f0ff; text-align: center; }
    tr:nth-child(even) { background: #f9f9f9; }
    h2 { color: darkblue; }

    /* Alignment kolom */
    td:nth-child(1), td:nth-child(4), td:nth-child(5), td:nth-child(6), td:nth-child(7) { 
      text-align: center; 
    }
    td:nth-child(2) { text-align: center; }
    td:nth-child(3) { text-align: left; padding-left: 15px; }
    .note {
    text-align: left;
    margin: 5px auto;
    width: 90%;     /* biar sejajar lebar tabel */
    font-size: 13px;
    color: #555;
    font-style: italic;
    }
  </style>
</head>
<body>
  <h2>👨‍🎓 Data Mahasiswa + Nilai</h2>
  <table>
    <tr>
      <th>No</th>
      <th>NIM</th>
      <th>Nama</th>
      <th>Umur</th>
      <th>Program Studi</th>
      <th>Nilai</th>
      <th>Status</th>
    </tr>
    <?php
    $no = 1;
    foreach ($mahasiswa as $mhs) {
        $status = ($mhs['nilai'] >= 70) ? "Lulus ✅" : "Tidak Lulus ❌";
        echo "<tr>
                <td>$no</td>
                <td>{$mhs['nim']}</td>
                <td>{$mhs['nama']}</td>
                <td>{$mhs['umur']}</td>
                <td>{$mhs['prodi']}</td>
                <td>{$mhs['nilai']}</td>
                <td>$status</td>
              </tr>";
        $no++;
    }
    ?>
  </table>

    <div class="note">
        Keterangan: Mahasiswa dinyatakan <b>Lulus</b> jika nilai ≥ 70, dan <b>Tidak Lulus</b> jika nilai &lt; 70.
    </div>
</body>
</html>
