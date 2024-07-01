<?php

// Menghubungkan ke file connect.php untuk koneksi database
include 'components/connect.php';

// Memulai sesi
session_start();

// Memeriksa apakah user_id ada dalam sesi
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id']; // Jika ada, simpan user_id dari sesi ke variabel $user_id
}else{
   $user_id = ''; // Jika tidak ada, set variabel $user_id menjadi string kosong
}

// Menghubungkan ke file wishlist_cart.php yang mungkin mengandung fungsi untuk mengelola wishlist dan keranjang
include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Untuk kompatibilitas dengan IE -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
   <title>kategory</title> <!-- Judul halaman -->
   
   <!-- Menghubungkan font awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Menghubungkan CSS kustom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Menghubungkan header pengguna -->
<?php include 'components/user_header.php'; ?>

<!-- Bagian produk berdasarkan kategori -->
<section class="products">

   <h1 class="heading">Kategori</h1> <!-- Judul bagian kategori -->

   <div class="box-container">

   <?php
     $category = $_GET['category']; // Mendapatkan kategori dari URL
     // Siapkan dan eksekusi query untuk memilih semua produk yang sesuai dengan kategori
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$category}%'"); 
     $select_products->execute();
     // Periksa apakah ada produk yang ditemukan
     if($select_products->rowCount() > 0){
      // Loop melalui setiap produk yang ditemukan
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <!-- Form untuk setiap produk -->
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>"> <!-- Hidden input untuk product_id -->
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>"> <!-- Hidden input untuk nama produk -->
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>"> <!-- Hidden input untuk harga produk -->
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>"> <!-- Hidden input untuk gambar produk -->
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button> <!-- Tombol untuk menambahkan ke wishlist -->
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a> <!-- Link untuk quick view -->
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt=""> <!-- Gambar produk -->
      <div class="name"><?= $fetch_product['name']; ?></div> <!-- Nama produk -->
      <div class="flex">
         <div class="price"><span>$</span><?= $fetch_product['price']; ?><span>/-</span></div> <!-- Harga produk -->
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1"> <!-- Input untuk jumlah -->
      </div>
      <input type="submit" value="Tambahkan ke keranjang" class="btn" name="add_to_cart"> <!-- Tombol untuk menambahkan ke keranjang -->
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">tidak ada produk yang ditemukan!</p>'; // Pesan jika tidak ada produk yang ditemukan
   }
   ?>

   </div>

</section>

<!-- Menghubungkan footer -->
<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script> <!-- Menghubungkan script kustom -->

</body>
</html>
