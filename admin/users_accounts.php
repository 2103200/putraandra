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

// Memeriksa apakah ada parameter 'delete' di URL
if(isset($_GET['delete'])){
   // Mendapatkan ID pengguna yang akan dihapus
   $delete_id = $_GET['delete'];
   
   // Menghapus pengguna dari tabel `users`
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   
   // Menghapus semua pesanan terkait pengguna dari tabel `orders`
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   
   // Menghapus semua pesan terkait pengguna dari tabel `messages`
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   
   // Menghapus semua item keranjang terkait pengguna dari tabel `cart`
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   
   // Menghapus semua item wishlist terkait pengguna dari tabel `wishlist`
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist->execute([$delete_id]);
   
   // Mengalihkan kembali ke halaman akun pengguna
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Accounts</title>

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

<section class="accounts">

   <h1 class="heading">User Accounts</h1>

   <div class="box-container">

   <?php
      // Menyiapkan perintah untuk mengambil semua akun pengguna
      $select_accounts = $conn->prepare("SELECT * FROM `users`");
      $select_accounts->execute();

      // Memeriksa apakah ada akun yang ditemukan
      if($select_accounts->rowCount() > 0){
         // Mengambil data akun satu per satu
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <!-- Menampilkan informasi pengguna -->
      <p> User ID : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Username : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p> Email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <!-- Tombol untuk menghapus akun pengguna -->
      <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('hapus akun ini? the user related information will also be delete!')" class="delete-btn">Delete</a>
   </div>
   <?php
         }
      }else{
         // Pesan jika tidak ada akun yang ditemukan
         echo '<p class="empty">Tidak ada akun yang tersedia!</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>