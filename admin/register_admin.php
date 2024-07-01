```php
<?php

// Menyertakan file koneksi ke database
include '../components/connect.php';

// Memulai sesi
session_start();

// Mendapatkan ID admin dari sesi
$admin_id = $_SESSION['admin_id'];

// Memeriksa apakah admin sudah login
if(!isset($admin_id)){
   // Jika belum, alihkan ke halaman login admin
   header('location:admin_login.php');
}

// Memeriksa apakah form telah disubmit
if(isset($_POST['submit'])){

   // Mendapatkan dan membersihkan input nama
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   
   // Mengenkripsi password dengan SHA-1 dan membersihkan input
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   
   // Mengenkripsi konfirmasi password dan membersihkan input
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   // Memeriksa apakah username sudah ada di database
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ?");
   $select_admin->execute([$name]);

   if($select_admin->rowCount() > 0){
      // Jika nama pengguna sudah ada, tampilkan pesan
      $message[] = 'nama pengguna sudah ada!';
   }else{
      // Memeriksa apakah password dan konfirmasi password cocok
      if($pass != $cpass){
         $message[] = 'konfirmasi kata sandi tidak cocok!';
      }else{
         // Menambahkan admin baru ke database
         $insert_admin = $conn->prepare("INSERT INTO `admins`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'admin baru berhasil terdaftar!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Daftar Admin</title>

   <!-- Menyertakan stylesheet dari Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Menyertakan stylesheet untuk halaman admin -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php 
// Menyertakan header admin
include '../components/admin_header.php'; 
?>

<section class="form-container">

   <!-- Form untuk pendaftaran admin baru -->
   <form action="" method="post">
      <h3>Daftar sekarang</h3>
      <!-- Input untuk username -->
      <input type="text" name="name" required placeholder="masukkan nama pengguna" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk password -->
      <input type="password" name="pass" required placeholder="masukkan kata sandi" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk konfirmasi password -->
      <input type="password" name="cpass" required placeholder="konfirmasi kata sandi" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Tombol submit untuk mendaftar -->
      <input type="submit" value="Daftar sekarang" class="btn" name="submit">
   </form>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>