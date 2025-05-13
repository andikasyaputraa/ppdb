<?php
// Fungsi untuk cek apakah user adalah admin
function cekAdmin() {
    // Mulai session jika belum dimulai
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Cek apakah role user adalah admin
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        // Jika bukan admin, redirect ke halaman login atau dashboard siswa
        header("Location: siswa_dashboard.php");
        exit();
    }
}
?>
