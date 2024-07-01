<?php

// Menghubungkan ke file connect.php yang berisi konfigurasi koneksi ke database
include 'components/connect.php';

// Memulai sesi PHP untuk melacak sesi pengguna
session_start();

// Mengecek apakah sesi user_id telah diatur, jika ya, mengambil nilai user_id dari sesi
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   // Jika tidak ada sesi user_id, mengatur user_id menjadi string kosong
   $user_id = '';
};

// Menghubungkan ke file wishlist_cart.php yang berisi logika untuk wishlist dan keranjang belanja
include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>
   
   <!-- Menyertakan link CDN untuk font awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Menyertakan file CSS kustom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Menyertakan file user_header.php yang berisi header pengguna -->
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h1 class="heading">Produk Terbaru</h1>

   <div class="box-container">

   <?php
     // Menyiapkan pernyataan SQL untuk mengambil semua data dari tabel products
     $select_products = $conn->prepare("SELECT * FROM products"); 
     // Menjalankan pernyataan SQL yang telah disiapkan
     $select_products->execute();
     // Mengecek apakah ada produk yang ditemukan
     if($select_products->rowCount() > 0){
      // Mengambil data produk satu per satu dan menampilkannya
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <!-- Tombol untuk menambah produk ke wishlist -->
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <!-- Link untuk melihat detail produk dengan cepat -->
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <!-- Menampilkan gambar produk -->
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <!-- Menampilkan nama produk -->
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <!-- Menampilkan harga produk -->
         <div class="price"><span>$</span><?= $fetch_product['price']; ?><span>/-</span></div>
         <!-- Input untuk jumlah produk yang ingin dibeli -->
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <!-- Tombol untuk menambah produk ke keranjang belanja -->
      <input type="submit" value="Masukkan ke keranjang" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      // Menampilkan pesan jika tidak ada produk yang ditemukan
      echo '<p class="empty">tidak ada produk yang ditemukan !</p>';
   }
   ?>

   </div>

</section>

<!-- Menyertakan file footer.php yang berisi footer situs -->
<?php include 'components/footer.php'; ?>

<!-- Menyertakan file JavaScript kustom -->
<script src="js/script.js"></script>

</body>
</html>