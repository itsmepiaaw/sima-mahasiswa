
<?php
require_once "includes/auth.php";
require_once "includes/language.php";
require_once "config/database.php";

// Menghitung jumlah mahasiswa
$sql = $pdo->query("SELECT COUNT(*) FROM mahasiswa");
$total_mahasiswa = $sql->fetchColumn();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - SIMA</title>
    <link rel="stylesheet" href="assets/css/style.css">
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
                <a href="index.php" class="active"><?= t('dashboard') ?></a>
                <a href="pages/daftar.php"><?= t('data_mahasiswa') ?></a>
            </nav>

            <div class="sidebar-bottom">
                <a href="logout.php"><?= t('logout') ?></a>
            </div>

        </aside>

        <!-- KONTEN UTAMA -->
        <main class="main-content">

            <!-- BAGIAN ATAS -->
            <div class="topbar">
                <div>
                    <h1><?= t('dashboard') ?></h1>
                    <p><?= t('deskripsi_dashboard') ?></p>
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
            <!-- PENUTUP TOPBAR -->

            <!-- KARTU SAMBUTAN -->
            <section class="welcome-card">
                <h2><?= t('halo') ?>, <?= htmlspecialchars($_SESSION['admin_username']) ?>! 👋</h2>
                <p><?= t('pesan_sambutan') ?></p>
            </section>

            <!-- RINGKASAN DATA -->
            <section class="stats">

                <div class="stat-card">
                    <div class="stat-icon">🎓</div>
                    <p><?= t('total_mahasiswa') ?></p>
                    <h2><?= $total_mahasiswa ?></h2>
                </div>

            </section>

            <!-- MENU PENGELOLAAN -->
            <section class="card dashboard-card">
                <h2><?= t('menu_pengelolaan') ?></h2>

                <p><?= t('menu_deskripsi') ?></p>

                <br>

                <a href="pages/daftar.php" class="btn">
                    <?= t('lihat_data') ?>
                </a>

                <a href="pages/tambah.php" class="btn btn-yellow">
                    + <?= t('tambah_mahasiswa') ?>
                </a>
            </section>

        </main>

    </div>

</body>
</html>
