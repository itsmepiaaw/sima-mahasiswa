
<?php
// Konfigurasi database
$host = "localhost";
$dbname = "sima_mahasiswa";
$username = "root";
$password = "";

try {
    // Membuat koneksi menggunakan PDO
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Mengatur mode error PDO
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
