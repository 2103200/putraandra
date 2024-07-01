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

   // Mendapatkan dan memfilter nama dari input
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   // Memperbarui nama profil admin di database
   $update_profile_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
   $update_profile_name->execute([$name, $admin_id]);

   // Mendefinisikan hash kata sandi kosong
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   
   // Mendapatkan data kata sandi dari input
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   // Memeriksa kesesuaian kata sandi
   if($old_pass == $empty_pass){
      // Jika kata sandi lama tidak diisi
      $message[] = 'silakan masukkan kata sandi lama!';
   }elseif($old_pass != $prev_pass){
      // Jika kata sandi lama tidak cocok
      $message[] = 'kata sandi lama tidak cocok!';
   }elseif($new_pass != $confirm_pass){
      // Jika konfirmasi kata sandi tidak cocok
      $message[] = 'konfirmasi kata sandi tidak cocok!';
   }else{
      // Memeriksa apakah kata sandi baru tidak kosong
      if($new_pass != $empty_pass){
         // Memperbarui kata sandi admin di database
         $update_admin_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$confirm_pass, $admin_id]);
         $message[] = 'kata sandi berhasil diperbarui!';
      }else{
         $message[] = 'silakan masukkan kata sandi baru!';
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
   <title>Memperbaharui Profil</title>

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

   <!-- Form untuk memperbarui profil -->
   <form action="" method="post">
      <h3>Memperbaharui Profil</h3>
      <!-- Menyimpan kata sandi lama untuk pengecekan -->
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
      <!-- Input untuk memperbarui nama pengguna -->
      <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="masukkan nama pengguna Anda" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk memasukkan kata sandi lama -->
      <input type="password" name="old_pass" placeholder="masukkan kata sandi lama" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk memasukkan kata sandi baru -->
      <input type="password" name="new_pass" placeholder="masukkan kata sandi baru" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk konfirmasi kata sandi baru -->
      <input type="password" name="confirm_pass" placeholder="konfirmasi password baru" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Tombol untuk submit pembaruan -->
      <input type="submit" value="memperbarui sekarang" class="btn" name="submit">
   </form>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>