<?php

// Menentukan nama database dan host
$db_name = 'mysql:host=localhost;dbname=shop_db';

// Menentukan nama pengguna database
$user_name = 'root';

// Menentukan kata sandi pengguna database (kosong untuk default)
$user_password = '';

// Membuat koneksi ke database menggunakan PDO
$conn = new PDO($db_name, $user_name, $user_password);

?>
