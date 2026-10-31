<?php
require_once "../includes/auth.php";
require_once "../config/database.php";

// Memastikan proses penghapusan menggunakan POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: daftar.php");
    exit;
}

// Mengambil ID mahasiswa
$id = $_POST["id"] ?? "";

// Memastikan ID valid
if (!ctype_digit((string)$id) || (int)$id < 1) {
    die("ID mahasiswa tidak valid.");
}

// Menghapus data berdasarkan ID
$sql = $pdo->prepare(
    "DELETE FROM mahasiswa WHERE id = ?"
);

$sql->execute([(int)$id]);

// Kembali ke halaman daftar
header("Location: daftar.php");
exit;
?>