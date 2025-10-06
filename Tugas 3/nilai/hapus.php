<?php
include '../koneksi.php';
$id = $_GET['id'];
$nilai = $conn->query("SELECT mahasiswa_id FROM nilai WHERE id=$id")->fetch_assoc();
$conn->query("DELETE FROM nilai WHERE id=$id");
header("Location: index.php?mahasiswa_id={$nilai['mahasiswa_id']}");
?>
