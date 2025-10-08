<?php
require_once '../koneksi.php';

// Jika request adalah AJAX POST (proses hapus)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    header("Content-Type: application/json");
    $response = ["status" => "error", "message" => "Terjadi kesalahan."];
    
    $id = intval($_POST["id"]);

    // Pastikan data nilai ada
    $stmt = $conn->prepare("SELECT id FROM nilai WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        $response = ["status" => "error", "message" => "Data nilai tidak ditemukan."];
    } else {
        // Hapus nilai
        $del = $conn->prepare("DELETE FROM nilai WHERE id = ?");
        $del->bind_param("i", $id);
        if ($del->execute()) {
            $response = ["status" => "success", "message" => "Data nilai berhasil dihapus!"];
        } else {
            $response = ["status" => "error", "message" => "Gagal menghapus data nilai."];
        }
        $del->close();
    }
    $stmt->close();
    
    echo json_encode($response);
    exit;
}
?>