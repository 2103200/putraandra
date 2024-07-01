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
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Untuk kompatibilitas dengan IE -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
   <title>about</title> <!-- Judul halaman -->

   <!-- Menghubungkan CSS dari Swiper -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- Menghubungkan font awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Menghubungkan CSS kustom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Menghubungkan header pengguna -->
<?php include 'components/user_header.php'; ?>

<!-- Bagian about -->
<section class="about">

   <div class="row">

      <div class="image">
         <!-- Gambar tentang -->
         <img src="images/about-img.svg" alt="">
      </div>

      <div class="content">
         <h3>mengapa memilih kami?</h3> <!-- Judul -->
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam veritatis minus et similique doloribus? Harum molestias tenetur eaque illum quas? Obcaecati nulla in itaque modi magnam ipsa molestiae ullam consequuntur.</p> <!-- Deskripsi -->
         <a href="contact.php" class="btn">contact us</a> <!-- Tombol kontak -->
      </div>

   </div>

</section>

<!-- Bagian ulasan -->
<section class="reviews">
   
   <h1 class="heading">ulasan klien</h1> <!-- Judul ulasan -->

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <!-- Mulai slide ulasan -->
      <div class="swiper-slide slide">
         <img src="images/pic-1.png" alt=""> <!-- Gambar pengguna -->
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.</p> <!-- Teks ulasan -->
         <div class="stars">
            <!-- Bintang rating -->
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3> <!-- Nama pengulas -->
      </div>

      <!-- Slide ulasan kedua -->
      <div class="swiper-slide slide">
         <img src="images/pic-2.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
      </div>

      <!-- Slide ulasan ketiga -->
      <div class="swiper-slide slide">
         <img src="images/pic-3.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
      </div>

      <!-- Slide ulasan keempat -->
      <div class="swiper-slide slide">
         <img src="images/pic-4.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
      </div>

      <!-- Slide ulasan kelima -->
      <div class="swiper-slide slide">
         <img src="images/pic-5.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
      </div>

      <!-- Slide ulasan keenam -->
      <div class="swiper-slide slide">
         <img src="images/pic-6.png" alt="">
         <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia tempore distinctio hic, iusto adipisci a rerum nemo perspiciatis fugiat sapiente.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
      </div>

   </div>

   <div class="swiper-pagination"></div> <!-- Pagination Swiper -->

   </div>

</section>

<!-- Menghubungkan footer -->
<?php include 'components/footer.php'; ?>

<!-- Menghubungkan script Swiper -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- Menghubungkan script kustom -->
<script src="js/script.js"></script>

<script>
// Inisialisasi Swiper
var swiper = new Swiper(".reviews-slider", {
   loop:true, // Membuat slide loop
   spaceBetween: 20, // Jarak antar slide
   pagination: {
      el: ".swiper-pagination", // Element untuk pagination
      clickable:true, // Membuat pagination bisa diklik
   },
   breakpoints: { // Pengaturan breakpoints untuk tampilan responsif
      0: {
        slidesPerView:1, // Jumlah slide yang ditampilkan pada layar kecil
      },
      768: {
        slidesPerView: 2, // Jumlah slide yang ditampilkan pada layar sedang
      },
      991: {
        slidesPerView: 3, // Jumlah slide yang ditampilkan pada layar besar
      },
   },
});

</script>

</body>
</html>
