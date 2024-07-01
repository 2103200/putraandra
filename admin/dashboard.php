<?php

// Menghubungkan file dengan 'connect.php' untuk koneksi database
include '../components/connect.php';

// Memulai sesi
session_start();

// Mendapatkan ID admin dari sesi
$admin_id = $_SESSION['admin_id'];

// Mengecek jika admin tidak terdaftar, maka akan diarahkan ke halaman login admin
if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Metadata dan link CSS -->
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- Link ke Font Awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link ke file CSS untuk admin -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<!-- Menyertakan header admin -->
<?php include '../components/admin_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">dashboard</h1>

   <div class="box-container">

      <!-- Menampilkan salam selamat datang kepada admin -->
      <div class="box">
         <h3>Selamat Datang!</h3>
         <p><?= $fetch_profile['name']; ?></p> <!-- Nama admin dari profil -->
         <a href="update_profile.php" class="btn">memperbaharui profil</a>
      </div>

      <!-- Menampilkan total pesanan tertunda -->
      <div class="box">
         <?php
            $total_pendings = 0; // Menginisialisasi total pesanan tertunda
            $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_pendings->execute(['pending']);
            if($select_pendings->rowCount() > 0){
               while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                  $total_pendings += $fetch_pendings['total_price']; // Menambahkan harga total pesanan tertunda
               }
            }
         ?>
         <h3><span>Rp.</span><?= $total_pendings; ?><span>/-</span></h3>
         <p>total tertunda</p>
         <a href="placed_orders.php" class="btn">lihat pesanan</a>
      </div>

      <!-- Menampilkan total pesanan yang selesai -->
      <div class="box">
         <?php
            $total_completes = 0; // Menginisialisasi total pesanan selesai
            $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_completes->execute(['completed']);
            if($select_completes->rowCount() > 0){
               while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                  $total_completes += $fetch_completes['total_price']; // Menambahkan harga total pesanan selesai
               }
            }
         ?>
         <h3><span>Rp.</span><?= $total_completes; ?><span>/-</span></h3>
         <p>pesanan selesai</p>
         <a href="placed_orders.php" class="btn">lihat pesanan</a>
      </div>

      <!-- Menampilkan total pesanan yang ditempatkan -->
      <div class="box">
         <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount(); // Menghitung jumlah total pesanan
         ?>
         <h3><?= $number_of_orders; ?></h3>
         <p>pesanan ditempatkan</p>
         <a href="placed_orders.php" class="btn">lihat pesanan</a>
      </div>

      <!-- Menampilkan total produk yang ditambahkan -->
      <div class="box">
         <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount(); // Menghitung jumlah total produk
         ?>
         <h3><?= $number_of_products; ?></h3>
         <p>produk ditambahkan</p>
         <a href="products.php" class="btn">Lihat produk</a>
      </div>

      <!-- Menampilkan total pengguna normal -->
      <div class="box">
         <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount(); // Menghitung jumlah total pengguna normal
         ?>
         <h3><?= $number_of_users; ?></h3>
         <p>normal users</p>
         <a href="users_accounts.php" class="btn">Lihat users</a>
      </div>

      <!-- Menampilkan total admin yang terdaftar -->
      <div class="box">
         <?php
            $select_admins = $conn->prepare("SELECT * FROM `admins`");
            $select_admins->execute();
            $number_of_admins = $select_admins->rowCount(); // Menghitung jumlah total admin
         ?>
         <h3><?= $number_of_admins; ?></h3>
         <p>admin users</p>
         <a href="admin_accounts.php" class="btn">Lihat admins</a>
      </div>

      <!-- Menampilkan total pesan baru -->
      <div class="box">
         <?php
            $select_messages = $conn->prepare("SELECT * FROM `messages`");
            $select_messages->execute();
            $number_of_messages = $select_messages->rowCount(); // Menghitung jumlah total pesan baru
         ?>
         <h3><?= $number_of_messages; ?></h3>
         <p>pesan baru</p>
         <a href="messages.php" class="btn">Lihat messages</a>
      </div>

   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
