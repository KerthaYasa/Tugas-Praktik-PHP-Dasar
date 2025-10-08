<?php
require_once 'koneksi.php';
header("Content-Type: application/json");

$response = ["status" => "error", "message" => "Terjadi kesalahan."];

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = intval($_POST["id"]);

    // Pastikan mahasiswa dengan ID tersebut ada
    $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        $response = ["status" => "error", "message" => "Data mahasiswa tidak ditemukan."];
    } else {
        // Hapus mahasiswa
        $del = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
        $del->bind_param("i", $id);

        if ($del->execute()) {
            $response = ["status" => "success", "message" => "Data mahasiswa berhasil dihapus!"];
        } else {
            $response = ["status" => "error", "message" => "Gagal menghapus data mahasiswa."];
        }
        $del->close();
    }

    $stmt->close();
}

echo json_encode($response);
exit;
?>
