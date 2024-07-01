<?php

// Menyertakan file koneksi database
include 'components/connect.php';

// Memulai sesi
session_start();

// Mengecek apakah user_id ada dalam sesi
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id']; // Jika ada, set user_id dari sesi
}else{
   $user_id = ''; // Jika tidak ada, set user_id menjadi kosong
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Untuk kompatibilitas dengan IE -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
   <title>pesanan</title> <!-- Judul halaman -->
   
   <!-- Link ke Font Awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link ke file CSS custom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; // Menyertakan header pengguna ?>

<section class="orders">

   <h1 class="heading">memesan</h1>

   <div class="box-container">

   <?php
      // Mengecek apakah user_id kosong
      if($user_id == ''){
         echo '<p class="empty">silahkan login untuk melihat pesanan anda</p>'; // Menampilkan pesan jika user belum login
      }else{
         // Mengambil data pesanan dari database berdasarkan user_id
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         
         // Mengecek apakah ada pesanan untuk user tersebut
         if($select_orders->rowCount() > 0){
            // Menampilkan setiap pesanan
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>ditempatkan pada : <span><?= $fetch_orders['placed_on']; ?></span></p> <!-- Tanggal penempatan pesanan -->
      <p>nama : <span><?= $fetch_orders['name']; ?></span></p> <!-- Nama pemesan -->
      <p>email : <span><?= $fetch_orders['email']; ?></span></p> <!-- Email pemesan -->
      <p>nomor handphone : <span><?= $fetch_orders['number']; ?></span></p> <!-- Nomor handphone pemesan -->
      <p>alamat : <span><?= $fetch_orders['address']; ?></span></p> <!-- Alamat pengiriman -->
      <p>metode pembayaran : <span><?= $fetch_orders['method']; ?></span></p> <!-- Metode pembayaran -->
      <p>pesanan Anda : <span><?= $fetch_orders['total_products']; ?></span></p> <!-- Daftar produk yang dipesan -->
      <p>total harga : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p> <!-- Total harga pesanan -->
      <p> Status pembayaran : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p> <!-- Status pembayaran -->
   </div>
   <?php
            }
         }else{
            // Menampilkan pesan jika tidak ada pesanan
            echo '<p class="empty">belum ada pesanan!</p>';
         }
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; // Menyertakan footer ?>

<!-- Menyertakan file JS custom -->
<script src="js/script.js"></script>

</body>
</html>
