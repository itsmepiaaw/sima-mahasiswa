
<?php
require_once "../includes/auth.php";
require_once "../includes/language.php";
require_once "../config/database.php";

$bahasa = $_SESSION['lang'] ?? 'id';

$error = "";

$nim = "";
$nama = "";
$jenis_kelamin = "";
$prodi = "";
$semester = "";
$email = "";

// Memproses form
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nim = trim($_POST["nim"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $jenis_kelamin = $_POST["jenis_kelamin"] ?? "";
    $prodi = trim($_POST["prodi"] ?? "");
    $semester = trim($_POST["semester"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if (
        $nim === "" ||
        $nama === "" ||
        $jenis_kelamin === "" ||
        $prodi === "" ||
        $semester === "" ||
        $email === ""
    ) {
        $error = $bahasa === 'en'
            ? "All fields must be filled in."
            : "Semua kolom wajib diisi.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = $bahasa === 'en'
            ? "Invalid email address."
            : "Format email tidak valid.";

    } elseif (!in_array($jenis_kelamin, ["Laki-laki", "Perempuan"], true)) {
        $error = $bahasa === 'en'
            ? "Invalid gender selection."
            : "Pilihan jenis kelamin tidak valid.";

    } elseif (!filter_var($semester, FILTER_VALIDATE_INT) ||
              $semester < 1 || $semester > 14) {
        $error = $bahasa === 'en'
            ? "Semester must be between 1 and 14."
            : "Semester harus antara 1 sampai 14.";

    } else {

        try {
            $sql = $pdo->prepare(
                "INSERT INTO mahasiswa
                (nim, nama, jenis_kelamin, prodi, semester, email)
                VALUES (?, ?, ?, ?, ?, ?)"
            );

            $sql->execute([
                $nim,
                $nama,
                $jenis_kelamin,
                $prodi,
                $semester,
                $email
            ]);

            header("Location: daftar.php");
            exit;

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = $bahasa === 'en'
                    ? "Student ID or email is already registered."
                    : "NIM atau email sudah terdaftar.";
            } else {
                $error = $bahasa === 'en'
                    ? "Failed to save student data."
                    : "Gagal menyimpan data mahasiswa.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $bahasa ?>">
<head>
    <meta charset="UTF-8">
    <title><?= t('tambah_mahasiswa') ?> - SIMA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <h2>Sistem Informasi Mahasiswa</h2>
            <p>Universitas Aman Sejahtera</p>
        </div>

        <nav>
            <a href="../index.php"><?= t('dashboard') ?></a>
            <a href="daftar.php"><?= t('data_mahasiswa') ?></a>
        </nav>

        <div class="sidebar-bottom">
            <a href="../logout.php"><?= t('logout') ?></a>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="main-content">

        <div class="topbar">
            <div>
                <h1><?= t('tambah_mahasiswa') ?></h1>
                <p>
                    <?= $bahasa === 'en'
                        ? 'Enter new student information below.'
                        : 'Masukkan informasi mahasiswa baru di bawah ini.' ?>
                </p>
            </div>

            <div class="topbar-right">
                <div class="language-switch">
                    <a href="?lang=id">Indonesia</a>
                    |
                    <a href="?lang=en">English</a>
                </div>

                <div class="admin-info">
                    Admin: <?= htmlspecialchars($_SESSION['admin_username']) ?>
                </div>
            </div>
        </div>

        <!-- FORM TAMBAH -->
        <div class="card form-card">

            <h2><?= t('tambah_mahasiswa') ?></h2>

            <p class="form-description">
                <?= $bahasa === 'en'
                    ? 'Please complete all student information.'
                    : 'Silakan lengkapi seluruh informasi mahasiswa.' ?>
            </p>

            <?php if ($error !== ""): ?>
                <div class="login-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="form-group">
                    <label><?= t('nim') ?></label>
                    <input type="text"
                           name="nim"
                           value="<?= htmlspecialchars($nim) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label><?= t('nama_lengkap') ?></label>
                    <input type="text"
                           name="nama"
                           value="<?= htmlspecialchars($nama) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label><?= t('jenis_kelamin') ?></label>
                    <select name="jenis_kelamin" required>
                        <option value="">
                            <?= $bahasa === 'en' ? 'Select Gender' : 'Pilih Jenis Kelamin' ?>
                        </option>

                        <option value="Laki-laki"
                            <?= $jenis_kelamin === "Laki-laki" ? "selected" : "" ?>>
                            <?= $bahasa === 'en' ? 'Male' : 'Laki-laki' ?>
                        </option>

                        <option value="Perempuan"
                            <?= $jenis_kelamin === "Perempuan" ? "selected" : "" ?>>
                            <?= $bahasa === 'en' ? 'Female' : 'Perempuan' ?>
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label><?= t('program_studi') ?></label>
                    <input type="text"
                           name="prodi"
                           value="<?= htmlspecialchars($prodi) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label><?= t('semester') ?></label>
                    <input type="number"
                           name="semester"
                           min="1"
                           max="14"
                           value="<?= htmlspecialchars($semester) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label><?= t('email') ?></label>
                    <input type="email"
                           name="email"
                           value="<?= htmlspecialchars($email) ?>"
                           required>
                </div>

                <div class="form-actions">
                    <button type="submit">
                        <?= t('simpan') ?>
                    </button>

                    <a href="daftar.php" class="btn btn-secondary">
                        <?= t('kembali') ?>
                    </a>
                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>
