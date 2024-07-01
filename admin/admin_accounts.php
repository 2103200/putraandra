<?php

// Menghubungkan file dengan 'connect.php' untuk koneksi database
include '../components/connect.php';

// Memulai sesi
session_start();

// Menyimpan admin_id dari session
$admin_id = $_SESSION['admin_id'];

// Jika admin_id tidak ada, alihkan ke halaman login admin
if(!isset($admin_id)){
   header('location:admin_login.php');
}

// Mengecek jika ada permintaan untuk menghapus akun admin
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete']; // Mengambil id admin yang akan dihapus
   // Menyiapkan query untuk menghapus admin dari database
   $delete_admins = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
   $delete_admins->execute([$delete_id]); // Mengeksekusi query dengan id yang diberikan
   header('location:admin_accounts.php'); // Mengarahkan ulang ke halaman akun admin
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Metadata dan link CSS -->
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin accounts</title>

   <!-- Link ke Font Awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link ke file CSS untuk admin -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; // Menyertakan header admin ?>

<section class="accounts">

   <h1 class="heading">akun admin</h1> <!-- Judul bagian akun admin -->

   <div class="box-container">

   <div class="box">
      <p>tambah admin baru</p>
      <a href="register_admin.php" class="option-btn">daftar admin</a> <!-- Tombol untuk menambah admin baru -->
   </div>

   <?php
      // Menyiapkan query untuk mengambil semua akun admin
      $select_accounts = $conn->prepare("SELECT * FROM `admins`");
      $select_accounts->execute();
      if($select_accounts->rowCount() > 0){
         // Loop melalui akun admin yang diambil
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> admin id : <span><?= $fetch_accounts['id']; ?></span> </p> <!-- Menampilkan ID admin -->
      <p> nama admin : <span><?= $fetch_accounts['name']; ?></span> </p> <!-- Menampilkan nama admin -->
      <div class="flex-btn">
         <!-- Tombol untuk menghapus admin -->
         <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('hapus akun ini?')" class="delete-btn">delete</a>
         <?php
            // Jika admin yang ditampilkan adalah admin yang sedang login, tampilkan opsi untuk memperbarui profil
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">update</a>';
            }
         ?>
      </div>
   </div>
   <?php
         }
      }else{
         // Jika tidak ada akun admin
         echo '<p class="empty">tidak ada akun yang tersedia!</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script> <!-- Script JavaScript untuk halaman admin -->
   
</body>
</html>
