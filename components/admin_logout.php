<?php

// Menyertakan file koneksi ke database
include 'connect.php';

// Memulai sesi
session_start();

// Menghapus semua variabel sesi
session_unset();

// Menghancurkan sesi saat ini
session_destroy();

// Mengarahkan pengguna ke halaman login admin
header('location:../admin/admin_login.php');

?>
