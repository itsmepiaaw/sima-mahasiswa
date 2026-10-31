
<?php

require_once __DIR__ . "/session.php";

// Memeriksa apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: /sima-mahasiswa/login.php");
    exit;
}
