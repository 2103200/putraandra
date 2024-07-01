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
};

// Memeriksa apakah ada permintaan untuk menghapus pesan
if(isset($_GET['delete'])){
   // Mendapatkan ID pesan yang akan dihapus dari parameter URL
   $delete_id = $_GET['delete'];
   // Mempersiapkan pernyataan SQL untuk menghapus pesan berdasarkan ID
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   // Menjalankan pernyataan dengan ID pesan sebagai parameter
   $delete_message->execute([$delete_id]);
   // Mengalihkan kembali ke halaman pesan setelah penghapusan
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pesan</title>

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

<section class="contacts">

<h1 class="heading">Pesan</h1>

<div class="box-container">

   <?php
      // Mempersiapkan pernyataan SQL untuk memilih semua pesan
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      // Menjalankan pernyataan SQL
      $select_messages->execute();
      // Memeriksa apakah ada pesan yang ditemukan
      if($select_messages->rowCount() > 0){
         // Mengambil dan menampilkan setiap pesan
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> user id : <span><?= $fetch_message['user_id']; ?></span></p>
      <p> name : <span><?= $fetch_message['name']; ?></span></p>
      <p> email : <span><?= $fetch_message['email']; ?></span></p>
      <p> no hp : <span><?= $fetch_message['number']; ?></span></p>
      <p> Pesan : <span><?= $fetch_message['message']; ?></span></p>
      <!-- Link untuk menghapus pesan dengan konfirmasi -->
      <a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('hapus pesan ini?');" class="delete-btn">Hapus</a>
   </div>
   <?php
         }
      }else{
         // Menampilkan pesan jika tidak ada pesan yang ditemukan
         echo '<p class="empty">kamu tidak punya pesan</p>';
      }
   ?>

</div>

</section>

<!-- Menyertakan skrip JavaScript untuk halaman admin -->
<script src="../js/admin_script.js"></script>
   
</body>
</html>
