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

// Menyertakan file wishlist dan keranjang
include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Untuk kompatibilitas dengan IE -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
   <title>halaman pencarian</title> <!-- Judul halaman -->
   
   <!-- Link ke Font Awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link ke file CSS custom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; // Menyertakan header pengguna ?>

<section class="search-form">
   <!-- Form untuk pencarian produk -->
   <form action="" method="post">
      <input type="text" name="search_box" placeholder="search here..." maxlength="100" class="box" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>
</section>

<section class="products" style="padding-top: 0; min-height:100vh;">

   <div class="box-container">

   <?php
     // Mengecek apakah ada input pencarian atau tombol pencarian yang ditekan
     if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
        // Mengambil nilai pencarian dari input
        $search_box = $_POST['search_box'];
        // Mengambil data produk dari database yang sesuai dengan pencarian
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'"); 
        $select_products->execute();
        // Mengecek apakah produk ditemukan
        if($select_products->rowCount() > 0){
           // Menampilkan data produk yang ditemukan
           while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <!-- Mengirim data produk sebagai input tersembunyi -->
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button> <!-- Tombol untuk menambahkan produk ke wishlist -->
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a> <!-- Link untuk melihat detail produk -->
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt=""> <!-- Menampilkan gambar produk -->
      <div class="name"><?= $fetch_product['name']; ?></div> <!-- Menampilkan nama produk -->
      <div class="flex">
         <!-- Menampilkan harga produk -->
         <div class="price"><span>$</span><?= $fetch_product['price']; ?><span>/-</span></div>
         <!-- Input untuk jumlah produk -->
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="Masukkan ke keranjang" class="btn" name="add_to_cart"> <!-- Tombol untuk menambahkan produk ke keranjang -->
   </form>
   <?php
            }
         }else{
            // Menampilkan pesan jika produk tidak ditemukan
            echo '<p class="empty">tidak ada produk yang ditemukan!</p>';
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
