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

// Memeriksa apakah ada permintaan untuk memperbarui status pembayaran
if(isset($_POST['update_payment'])){
   // Mendapatkan ID pesanan dan status pembayaran dari form
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   // Membersihkan input untuk keamanan
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   // Mempersiapkan pernyataan SQL untuk memperbarui status pembayaran
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   // Menjalankan pernyataan dengan parameter yang sesuai
   $update_payment->execute([$payment_status, $order_id]);
   // Menyimpan pesan bahwa status pembayaran berhasil diperbarui
   $message[] = 'status pembayaran diperbarui!';
}

// Memeriksa apakah ada permintaan untuk menghapus pesanan
if(isset($_GET['delete'])){
   // Mendapatkan ID pesanan yang akan dihapus dari parameter URL
   $delete_id = $_GET['delete'];
   // Mempersiapkan pernyataan SQL untuk menghapus pesanan berdasarkan ID
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   // Menjalankan pernyataan dengan ID pesanan sebagai parameter
   $delete_order->execute([$delete_id]);
   // Mengalihkan kembali ke halaman pesanan setelah penghapusan
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Memesan</title>

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

<section class="orders">

<h1 class="heading">Memesan</h1>

<div class="box-container">

   <?php
      // Mempersiapkan pernyataan SQL untuk memilih semua pesanan
      $select_orders = $conn->prepare("SELECT * FROM `orders`");
      // Menjalankan pernyataan SQL
      $select_orders->execute();
      // Memeriksa apakah ada pesanan yang ditemukan
      if($select_orders->rowCount() > 0){
         // Mengambil dan menampilkan setiap pesanan
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Ditempatkan pada : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Nama : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> No HP : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Alamat : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Total Produk : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Total Pembayaran : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> Metode Pembayaran : <span><?= $fetch_orders['method']; ?></span> </p>
      <!-- Form untuk memperbarui status pembayaran -->
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="payment_status" class="select">
            <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">Tertunda</option>
            <option value="completed">Selesai</option>
         </select>
         <div class="flex-btn">
            <!-- Tombol untuk mengupdate status pembayaran -->
            <input type="submit" value="Update" class="option-btn" name="update_payment">
            <!-- Link untuk menghapus pesanan dengan konfirmasi -->
            <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Hapus pesanan ini?');">Hapus</a>
         </div>
      </form>
   </div>
   <?php
         }
      }else{
         // Menampilkan pesan jika tidak ada pesanan yang ditemukan
         echo '<p class="empty">Belum ada pesanan!</p>';
      }
   ?>

</div>

</section>

<!-- Menyertakan skrip JavaScript untuk halaman admin -->
<script src="../js/admin_script.js"></script>
   
</body>
</html>
