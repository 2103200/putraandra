<?php

// Menyertakan file koneksi database
include 'components/connect.php';

// Memulai sesi
session_start();

// Mengecek apakah user_id ada dalam sesi
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id']; // Jika ada, set user_id dari sesi
} else {
   $user_id = ''; // Jika tidak ada, set user_id menjadi kosong
};

// Menyertakan file wishlist dan keranjang
include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Untuk kompatibilitas dengan IE -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
   <title>home</title> <!-- Judul halaman -->

   <!-- Link ke Swiper CSS untuk slider -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- Link ke Font Awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link ke file CSS custom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; // Menyertakan header pengguna ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <!-- Slide 1 -->
      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-1.png" alt="">
         </div>
         <div class="content">
            <span>upto 50% off</span>
            <h3>Smartphones Terbaru</h3>
            <a href="shop.php" class="btn">Beli Sekarang</a>
         </div>
      </div>

      <!-- Slide 2 -->
      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-2.png" alt="">
         </div>
         <div class="content">
            <span>diskon hingga 50%</span>
            <h3>jam tangan terbaru</h3>
            <a href="shop.php" class="btn">Beli Sekarang</a>
         </div>
      </div>

      <!-- Slide 3 -->
      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/home-img-3.png" alt="">
         </div>
         <div class="content">
         <span>diskon hingga 50%</span>
            <h3>Headsets Terbaru</h3>
            <a href="shop.php" class="btn">Beli Sekarang</a>
         </div>
      </div>

   </div>

      <!-- Pagination Swiper -->
      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<section class="category">

   <h1 class="heading">berbelanja berdasarkan kategori</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <!-- Kategori laptop -->
   <a href="category.php?category=laptop" class="swiper-slide slide">
      <img src="images/icon-1.png" alt="">
      <h3>laptop</h3>
   </a>

   <!-- Kategori TV -->
   <a href="category.php?category=tv" class="swiper-slide slide">
      <img src="images/icon-2.png" alt="">
      <h3>tv</h3>
   </a>

   <!-- Kategori kamera -->
   <a href="category.php?category=camera" class="swiper-slide slide">
      <img src="images/icon-3.png" alt="">
      <h3>camera</h3>
   </a>

   <!-- Kategori mouse -->
   <a href="category.php?category=mouse" class="swiper-slide slide">
      <img src="images/icon-4.png" alt="">
      <h3>mouse</h3>
   </a>

   <!-- Kategori kulkas -->
   <a href="category.php?category=fridge" class="swiper-slide slide">
      <img src="images/icon-5.png" alt="">
      <h3>fridge</h3>
   </a>

   <!-- Kategori mesin cuci -->
   <a href="category.php?category=washing" class="swiper-slide slide">
      <img src="images/icon-6.png" alt="">
      <h3>washing machine</h3>
   </a>

   <!-- Kategori smartphone -->
   <a href="category.php?category=smartphone" class="swiper-slide slide">
      <img src="images/icon-7.png" alt="">
      <h3>smartphone</h3>
   </a>

   <!-- Kategori jam tangan -->
   <a href="category.php?category=watch" class="swiper-slide slide">
      <img src="images/icon-8.png" alt="">
      <h3>watch</h3>
   </a>

   </div>

   <!-- Pagination Swiper -->
   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="home-products">

   <h1 class="heading">Produk Terbaru</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper">

   <?php
     // Mengambil data produk dari database dengan batas 6
     $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
        // Menampilkan setiap produk yang diambil dari database
        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <!-- Form untuk setiap produk -->
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>$</span><?= $fetch_product['price']; ?><span>/-</span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="Tambahkan Ke keranjang" class="btn" name="add_to_cart">
   </form>
   <?php
        }
     } else {
        // Jika tidak ada produk yang ditemukan
        echo '<p class="empty">belum ada produk yang ditambahkan!</p>';
     }
   ?>

   </div>

   <!-- Pagination Swiper -->
   <div class="swiper-pagination"></div>

   </div>

</section>

<?php include 'components/footer.php'; // Menyertakan footer ?>

<!-- Menyertakan Swiper JS untuk slider -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- Menyertakan file JS custom -->
<script src="js/script.js"></script>

<script>
// Inisialisasi Swiper untuk slider beranda
var swiper = new Swiper(".home-slider", {
   loop: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
});

// Inisialisasi Swiper untuk slider kategori
var swiper = new Swiper(".category-slider", {
   loop: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

// Inisialisasi Swiper untuk slider produk
var swiper = new Swiper(".products-slider", {
   loop: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>
