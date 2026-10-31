<?php
require_once __DIR__ . "/session.php";

// Mengatur bahasa berdasarkan pilihan admin
if (isset($_GET['lang'])) {
    $pilihan = $_GET['lang'];

    if (in_array($pilihan, ['id', 'en'], true)) {
        $_SESSION['lang'] = $pilihan;
    }

    // Menghindari pengiriman ulang parameter bahasa
    $halaman = strtok($_SERVER['REQUEST_URI'], '?');
    header("Location: " . $halaman);
    exit;
}

// Bahasa default adalah Indonesia
$bahasa = $_SESSION['lang'] ?? 'id';

// Daftar terjemahan
$translations = [

    'id' => [
        'dashboard' => 'Dashboard',
        'data_mahasiswa' => 'Data Mahasiswa',
        'tambah_mahasiswa' => 'Tambah Mahasiswa',
        'edit_mahasiswa' => 'Edit Mahasiswa',
        'logout' => 'Keluar',
        'selamat_datang' => 'Selamat Datang',
        'total_mahasiswa' => 'Total Mahasiswa',
        'menu_pengelolaan' => 'Menu Pengelolaan',
        'lihat_data' => 'Lihat Data Mahasiswa',
        'nama_lengkap' => 'Nama Lengkap',
        'jenis_kelamin' => 'Jenis Kelamin',
        'program_studi' => 'Program Studi',
        'semester' => 'Semester',
        'email' => 'Email',
        'simpan' => 'Simpan Data',
        'simpan_perubahan' => 'Simpan Perubahan',
        'kembali' => 'Kembali',
        'nim' => 'NIM',
        'aksi' => 'Aksi',
        'belum_ada_data' => 'Belum ada data mahasiswa.',
        'pesan_sambutan' => 'Kelola data mahasiswa dengan mudah melalui dashboard ini.',
        'deskripsi_dashboard' => 'Selamat datang di Sistem Informasi Mahasiswa.',
        'menu_deskripsi' => 'Gunakan menu berikut untuk melihat dan mengelola data mahasiswa.',
        'halo' => 'Halo',
    ],

    'en' => [
        'dashboard' => 'Dashboard',
        'data_mahasiswa' => 'Student Data',
        'tambah_mahasiswa' => 'Add Student',
        'edit_mahasiswa' => 'Edit Student',
        'logout' => 'Logout',
        'selamat_datang' => 'Welcome',
        'total_mahasiswa' => 'Total Students',
        'menu_pengelolaan' => 'Management Menu',
        'lihat_data' => 'View Student Data',
        'nama_lengkap' => 'Full Name',
        'jenis_kelamin' => 'Gender',
        'program_studi' => 'Study Program',
        'semester' => 'Semester',
        'email' => 'Email',
        'simpan' => 'Save Data',
        'simpan_perubahan' => 'Save Changes',
        'kembali' => 'Back',
        'nim' => 'Student ID',
        'aksi' => 'Actions',
        'belum_ada_data' => 'No student data available.',
        'pesan_sambutan' => 'Manage student data easily through this dashboard.',
        'deskripsi_dashboard' => 'Welcome to the Student Information System.',
        'menu_deskripsi' => 'Use the following menu to view and manage student data.',
        'halo' => 'Hello',
    ]
];

// Fungsi untuk mengambil terjemahan
function t($key) {
    global $translations, $bahasa;

    return $translations[$bahasa][$key] ?? $key;
}
?>