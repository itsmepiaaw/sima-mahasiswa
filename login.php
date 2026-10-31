
<?php
require_once "includes/session.php";
require_once "includes/language.php";
require_once "config/database.php";

$bahasa = $_SESSION['lang'] ?? 'id';

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {
        $error = $bahasa === 'en'
            ? "Username and password are required."
            : "Username dan password wajib diisi.";

    } else {

        $sql = $pdo->prepare(
            "SELECT * FROM admin WHERE username = ?"
        );
        $sql->execute([$username]);

        $admin = $sql->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {

            // Membuat session baru setelah login
            session_regenerate_id(true);

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: index.php");
            exit;

        } else {
            $error = $bahasa === 'en'
                ? "Incorrect username or password."
                : "Username atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $bahasa ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $bahasa === 'en' ? 'Login' : 'Masuk' ?> - Sistem Informasi Mahasiswa</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-page">

    <div class="login-container">

        <div class="login-card">

            <!-- PILIHAN BAHASA -->
            <div class="language-switch" style="text-align: center; margin-bottom: 20px;">
                <a href="?lang=id">Indonesia</a>
                |
                <a href="?lang=en">English</a>
            </div>

            <!-- LOGO -->
            <div class="login-logo">
                <div class="login-icon">🎓</div>

                <h1>Sistem Informasi Mahasiswa</h1>
                <p>Universitas Aman Sejahtera</p>
            </div>

            <!-- JUDUL LOGIN -->
            <div class="login-heading">
                <h2>
                    <?= $bahasa === 'en' ? 'Welcome!' : 'Selamat Datang!' ?>
                </h2>

                <p>
                    <?= $bahasa === 'en'
                        ? 'Please log in to continue.'
                        : 'Silakan login untuk melanjutkan.' ?>
                </p>
            </div>

            <!-- PESAN ERROR -->
            <?php if (!empty($error)): ?>
                <div class="login-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- FORM LOGIN -->
            <form method="POST">

                <div class="form-group">
                    <label>
                        <?= $bahasa === 'en' ? 'Username' : 'Username' ?>
                    </label>

                    <input
                        type="text"
                        name="username"
                        placeholder="<?= $bahasa === 'en' ? 'Enter username' : 'Masukkan username' ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>
                        <?= $bahasa === 'en' ? 'Password' : 'Password' ?>
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="<?= $bahasa === 'en' ? 'Enter password' : 'Masukkan password' ?>"
                        required
                    >
                </div>

                <button type="submit" class="login-button">
                    <?= $bahasa === 'en' ? 'Sign In' : 'Masuk' ?>
                </button>

            </form>

        </div>

    </div>

</body>
</html>
