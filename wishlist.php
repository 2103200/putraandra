<?php

// Menghubungkan ke file connect.php yang berisi konfigurasi koneksi ke database
include 'components/connect.php';

// Memulai sesi PHP untuk melacak sesi pengguna
session_start();

// Mengecek apakah sesi user_id telah diatur, jika ya, mengambil nilai user_id dari sesi
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   // Jika tidak ada sesi user_id, mengarahkan pengguna ke halaman login
   $user_id = '';
   header('location:user_login.php');
};

// Menghubungkan ke file wishlist_cart.php untuk mengelola wishlist dan keranjang belanja
include 'components/wishlist_cart.php';

// Mengecek apakah form dengan nama 'delete' telah disubmit
if(isset($_POST['delete'])){
   // Mengambil id wishlist dari form
   $wishlist_id = $_POST['wishlist_id'];
   // Menyiapkan pernyataan SQL untuk menghapus item dari wishlist berdasarkan id
   $delete_wishlist_item = $conn->prepare("DELETE FROM wishlist WHERE id = ?");
   // Menjalankan pernyataan SQL yang telah disiapkan
   $delete_wishlist_item->execute([$wishlist_id]);
}

// Mengecek apakah ada parameter 'delete_all' di URL
if(isset($_GET['delete_all'])){
   // Menyiapkan pernyataan SQL untuk menghapus semua item dari wishlist untuk pengguna saat ini
   $delete_wishlist_item = $conn->prepare("DELETE FROM wishlist WHERE user_id = ?");
   // Menjalankan pernyataan SQL yang telah disiapkan
   $delete_wishlist_item->execute([$user_id]);
   // Mengarahkan ulang ke halaman wishlist
   header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>
   
   <!-- Menyertakan link CDN untuk font awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Menyertakan file CSS kustom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Menyertakan file user_header.php yang berisi header pengguna -->
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h3 class="heading">your wishlist</h3>

   <div class="box-container">

   <?php
      // Inisialisasi total keseluruhan harga wishlist
      $grand_total = 0;
      // Menyiapkan pernyataan SQL untuk memilih semua item wishlist untuk pengguna saat ini
      $select_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ?");
      // Menjalankan pernyataan SQL yang telah disiapkan
      $select_wishlist->execute([$user_id]);
      // Mengecek apakah ada item di wishlist
      if($select_wishlist->rowCount() > 0){
         // Mengambil setiap item di wishlist sebagai array asosiatif
         while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
            // Menambahkan harga item ke total keseluruhan
            $grand_total += $fetch_wishlist['price'];  
   ?>
   <form action="" method="post" class="box">
      <!-- Menyimpan data item wishlist dalam input tersembunyi -->
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
      <!-- Link untuk melihat item dengan cepat -->
      <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
      <!-- Menampilkan gambar item -->
      <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
      <!-- Menampilkan nama item -->
      <div class="name"><?= $fetch_wishlist['name']; ?></div>
      <div class="flex">
         <!-- Menampilkan harga item -->
         <div class="price">$<?= $fetch_wishlist['price']; ?>/-</div>
         <!-- Input untuk jumlah item yang ingin ditambahkan ke keranjang -->
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <!-- Tombol untuk menambahkan item ke keranjang -->
      <input type="submit" value="Masukkan ke keranjang" class="btn" name="add_to_cart">
      <!-- Tombol untuk menghapus item dari wishlist -->
      <input type="submit" value="hapus item" onclick="return confirm('hapus ini dari daftar keinginan?');" class="delete-btn" name="delete">
   </form>
   <?php
      }
   }else{
      // Pesan jika wishlist kosong
      echo '<p class="empty">Daftar keinginan anda kosong</p>';
   }
   ?>
   </div>

   <div class="wishlist-total">
      <!-- Menampilkan total keseluruhan harga wishlist -->
      <p>grand total : <span>$<?= $grand_total; ?>/-</span></p>
      <!-- Tombol untuk melanjutkan belanja -->
      <a href="shop.php" class="option-btn">continue shopping</a>
      <!-- Tombol untuk menghapus semua item dari wishlist -->
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('hapus semua dari wishlist?');">hapus semua item</a>
   </div>

</section>

<!-- Menyertakan file footer.php yang berisi footer situs -->
<?php include 'components/footer.php'; ?>

<!-- Menyertakan file JavaScript kustom -->
<script src="js/script.js"></script>

</body>
</html>