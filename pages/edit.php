
<?php
require_once "../includes/auth.php";
require_once "../includes/language.php";
require_once "../config/database.php";

$bahasa = $_SESSION['lang'] ?? 'id';

$error = "";

// Mengambil ID mahasiswa dari URL
$id = $_GET["id"] ?? "";

// Memastikan ID berupa angka
if (!ctype_digit((string)$id) || (int)$id < 1) {
    die($bahasa === 'en'
        ? "Invalid student ID."
        : "ID mahasiswa tidak valid.");
}

// Mengambil data mahasiswa berdasarkan ID
$sql = $pdo->prepare(
    "SELECT * FROM mahasiswa WHERE id = ?"
);
$sql->execute([(int)$id]);

$m = $sql->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan
if (!$m) {
    die($bahasa === 'en'
        ? "Student data not found."
        : "Data mahasiswa tidak ditemukan.");
}

// Memproses perubahan data
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nim = trim($_POST["nim"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $jenis_kelamin = $_POST["jenis_kelamin"] ?? "";
    $prodi = trim($_POST["prodi"] ?? "");
    $semester = trim($_POST["semester"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if (
        $nim === "" || $nama === "" ||
        $jenis_kelamin === "" || $prodi === "" ||
        $semester === "" || $email === ""
    ) {
        $error = $bahasa === 'en'
            ? "All fields must be filled in."
            : "Semua kolom wajib diisi.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = $bahasa === 'en'
            ? "Invalid email format."
            : "Format email tidak valid.";

    } elseif (!in_array(
        $jenis_kelamin,
        ["Laki-laki", "Perempuan"],
        true
    )) {
        $error = $bahasa === 'en'
            ? "Invalid gender."
            : "Jenis kelamin tidak valid.";

    } elseif (
        !ctype_digit($semester) ||
        (int)$semester < 1 ||
        (int)$semester > 14
    ) {
        $error = $bahasa === 'en'
            ? "Semester must be between 1 and 14."
            : "Semester harus antara 1 sampai 14.";

    } else {
        try {
            $sql = $pdo->prepare(
                "UPDATE mahasiswa
                SET nim = ?, nama = ?, jenis_kelamin = ?,
                    prodi = ?, semester = ?, email = ?
                WHERE id = ?"
            );

            $sql->execute([
                $nim,
                $nama,
                $jenis_kelamin,
                $prodi,
                (int)$semester,
                $email,
                (int)$id
            ]);

            header("Location: daftar.php");
            exit;

        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $error = $bahasa === 'en'
                    ? "Student ID or email is already in use."
                    : "NIM atau email sudah digunakan.";
            } else {
                $error = $bahasa === 'en'
                    ? "An error occurred while updating the data."
                    : "Terjadi kesalahan saat memperbarui data.";
            }
        }
    }

    // Mempertahankan data yang diketik jika terjadi kesalahan
    $m["nim"] = $nim;
    $m["nama"] = $nama;
    $m["jenis_kelamin"] = $jenis_kelamin;
    $m["prodi"] = $prodi;
    $m["semester"] = $semester;
    $m["email"] = $email;
}
?>

<!DOCTYPE html>
<html lang="<?= $bahasa ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= t('edit_mahasiswa') ?> - SIMA</title>
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
            <a href="daftar.php" class="active"><?= t('data_mahasiswa') ?></a>
        </nav>

        <div class="sidebar-bottom">
            <a href="../logout.php"><?= t('logout') ?></a>
        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="main-content">

        <div class="topbar">

            <div>
                <h1><?= t('edit_mahasiswa') ?></h1>
                <p>
                    <?= $bahasa === 'en'
                        ? 'Update student information.'
                        : 'Perbarui informasi data mahasiswa.' ?>
                </p>
            </div>

            <div class="topbar-right">

                <div class="language-switch">
                    <a href="?id=<?= (int)$id ?>&lang=id">Indonesia</a>
                    |
                    <a href="?id=<?= (int)$id ?>&lang=en">English</a>
                </div>

                <div class="admin-info">
                    Admin: <?= htmlspecialchars($_SESSION['admin_username']) ?>
                </div>

            </div>

        </div>

        <!-- FORM EDIT -->
        <div class="card form-card">

            <h2><?= $bahasa === 'en'
                ? 'Edit Student Form'
                : 'Form Edit Mahasiswa' ?></h2>

            <p class="form-description">
                <?= $bahasa === 'en'
                    ? 'Please update the necessary student information.'
                    : 'Silakan ubah informasi mahasiswa yang diperlukan.' ?>
            </p>

            <?php if ($error !== ""): ?>
                <div class="login-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="form-group">
                    <label><?= t('nim') ?></label>
                    <input type="text" name="nim"
                        value="<?= htmlspecialchars($m['nim']) ?>" required>
                </div>

                <div class="form-group">
                    <label><?= t('nama_lengkap') ?></label>
                    <input type="text" name="nama"
                        value="<?= htmlspecialchars($m['nama']) ?>" required>
                </div>

                <div class="form-group">
                    <label><?= t('jenis_kelamin') ?></label>
                    <select name="jenis_kelamin" required>

                        <option value="Laki-laki"
                            <?= $m['jenis_kelamin'] === 'Laki-laki' ? 'selected' : '' ?>>
                            <?= $bahasa === 'en' ? 'Male' : 'Laki-laki' ?>
                        </option>

                        <option value="Perempuan"
                            <?= $m['jenis_kelamin'] === 'Perempuan' ? 'selected' : '' ?>>
                            <?= $bahasa === 'en' ? 'Female' : 'Perempuan' ?>
                        </option>

                    </select>
                </div>

                <div class="form-group">
                    <label><?= t('program_studi') ?></label>
                    <input type="text" name="prodi"
                        value="<?= htmlspecialchars($m['prodi']) ?>" required>
                </div>

                <div class="form-group">
                    <label><?= t('semester') ?></label>
                    <input type="number" name="semester"
                        min="1" max="14"
                        value="<?= htmlspecialchars((string)$m['semester']) ?>"
                        required>
                </div>

                <div class="form-group">
                    <label><?= t('email') ?></label>
                    <input type="email" name="email"
                        value="<?= htmlspecialchars($m['email']) ?>" required>
                </div>

                <div class="form-actions">

                    <button type="submit" class="btn">
                        <?= t('simpan_perubahan') ?>
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
