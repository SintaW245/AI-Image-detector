<?php
// clear_history.php - Hapus riwayat deteksi
session_start();

// Validasi request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: history.php');
    exit();
}

// Hapus history dari session
unset($_SESSION['history']);

// Set pesan sukses
$_SESSION['message'] = 'Riwayat berhasil dihapus!';
$_SESSION['message_type'] = 'success';

// Redirect kembali ke halaman history
header('Location: history.php');
exit();
?>