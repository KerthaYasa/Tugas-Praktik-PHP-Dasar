<?php
$mahasiswa = [
    "2205551001" => "Komang",
    "2205551002" => "Budi",
    "2205551003" => "Sari",
    "2205551004" => "Dewi",
    "2205551005" => "Andi",
    "2405551034" => "Cahya Kertha",
    "2405551035" => "Reva Majesty",
    "2405551036" => "Agus Hendra",
    "2405551037" => "Daffa Adhi",
    "2405551038" => "Geemtong"
];

echo "<h3>Daftar Mahasiswa</h3>";
echo "<ul>";
foreach ($mahasiswa as $nim => $nama) {
    echo "<li>NIM: $nim -- Nama: $nama</li>";
}
echo "</ul>";
?>