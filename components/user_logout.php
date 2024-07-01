<?php

// Menyertakan file connect.php yang berisi konfigurasi koneksi ke database
include 'connect.php';

// Memulai sesi PHP
session_start();

// Menghapus semua variabel sesi
session_unset();

// Menghancurkan sesi yang sedang berlangsung
session_destroy();

// Mengarahkan pengguna ke halaman home.php
header('location:../home.php');

?>
