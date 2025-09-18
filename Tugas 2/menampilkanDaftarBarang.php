<?php
    $barang = ["Buku Tulis", "Pulpen", "Penggaris", "Penghapus"];

    echo "<h3>Daftar Barang:</h3>";
    echo "<ul>";
    foreach ($barang as $b) {
        echo "<li>$b</li>";
    }
    echo "</ul>";
?>
