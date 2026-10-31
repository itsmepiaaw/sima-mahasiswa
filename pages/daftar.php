
<?php
require_once "../includes/auth.php";
require_once "../includes/language.php";
require_once "../config/database.php";

$bahasa = $_SESSION['lang'] ?? 'id';

// Mengambil seluruh data mahasiswa
$sql = $pdo->query(
    "SELECT * FROM mahasiswa ORDER BY id DESC"
);

$mahasiswa = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="<?= $bahasa ?>">
<head>
    <meta charset="UTF-8">
    <title><?= t('data_mahasiswa') ?> - SIMA</title>
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
                <a href="daftar.php" class="active">
                    <?= t('data_mahasiswa') ?>
                </a>
            </nav>

            <div class="sidebar-bottom">
                <a href="../logout.php"><?= t('logout') ?></a>
            </div>

        </aside>

        <!-- KONTEN UTAMA -->
        <main class="main-content">

            <!-- BAGIAN ATAS -->
            <div class="topbar">

                <div>
                    <h1><?= t('data_mahasiswa') ?></h1>
                    <p>
                        <?= $bahasa === 'en'
                            ? 'Manage all student data here.'
                            : 'Kelola seluruh data mahasiswa di sini.' ?>
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

            <!-- TOMBOL TAMBAH -->
            <div class="action-bar">
                <a href="tambah.php" class="btn btn-yellow">
                    + <?= t('tambah_mahasiswa') ?>
                </a>
            </div>

            <!-- TABEL DATA -->
            <div class="card">

                <h2><?= t('data_mahasiswa') ?></h2>

                <table>
                    <tr>
                        <th><?= $bahasa === 'en' ? 'No.' : 'No' ?></th>
                        <th><?= t('nim') ?></th>
                        <th><?= t('nama_lengkap') ?></th>
                        <th><?= t('jenis_kelamin') ?></th>
                        <th><?= t('program_studi') ?></th>
                        <th><?= t('semester') ?></th>
                        <th><?= t('email') ?></th>
                        <th><?= t('aksi') ?></th>
                    </tr>

                    <?php if (count($mahasiswa) > 0): ?>

                        <?php foreach ($mahasiswa as $index => $m): ?>

                            <tr>
                                <td><?= $index + 1 ?></td>

                                <td>
                                    <?= htmlspecialchars($m['nim']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($m['nama']) ?>
                                </td>

                                <td>
                                    <?= $bahasa === 'en'
                                        ? ($m['jenis_kelamin'] === 'Laki-laki' ? 'Male' : 'Female')
                                        : htmlspecialchars($m['jenis_kelamin']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($m['prodi']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($m['semester']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($m['email']) ?>
                                </td>

                                <td>
                                    <a href="edit.php?id=<?= $m['id'] ?>">
                                        <?= $bahasa === 'en' ? 'Edit' : 'Edit' ?>
                                    </a>

                                    <form action="hapus.php"
                                          method="POST"
                                          style="display:inline;"
                                          onsubmit="return confirm('<?= $bahasa === 'en' ? 'Are you sure you want to delete this data?' : 'Yakin ingin menghapus data ini?' ?>');">

                                        <input type="hidden"
                                               name="id"
                                               value="<?= $m['id'] ?>">

                                        <button type="submit">
                                            <?= $bahasa === 'en' ? 'Delete' : 'Hapus' ?>
                                        </button>

                                    </form>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="8">
                                <?= t('belum_ada_data') ?>
                            </td>
                        </tr>

                    <?php endif; ?>

                </table>

            </div>

        </main>

    </div>

</body>
</html>
