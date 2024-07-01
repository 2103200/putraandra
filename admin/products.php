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
};

// Memeriksa apakah ada permintaan untuk menambahkan produk
if(isset($_POST['add_product'])){

   // Mendapatkan data produk dari form
   $name = $_POST['name'];
   // Membersihkan input nama produk untuk keamanan
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   // Membersihkan input harga produk
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   // Membersihkan input detail produk
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   // Mendapatkan data gambar pertama
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   // Mendapatkan data gambar kedua
   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   // Mendapatkan data gambar ketiga
   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   // Memeriksa apakah nama produk sudah ada di database
   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      // Jika produk sudah ada, tampilkan pesan
      $message[] = 'nama produk sudah ada!';
   }else{
      // Memasukkan produk baru ke database
      $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price, image_01, image_02, image_03) VALUES(?,?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $image_01, $image_02, $image_03]);

      if($insert_products){
         // Memeriksa ukuran gambar
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message[] = 'ukuran gambar terlalu besar!';
         }else{
            // Memindahkan file gambar ke folder tujuan
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'produk baru ditambahkan!';
         }
      }
   }  
};

// Memeriksa apakah ada permintaan untuk menghapus produk
if(isset($_GET['delete'])){

   // Mendapatkan ID produk yang akan dihapus dari parameter URL
   $delete_id = $_GET['delete'];
   // Mendapatkan data produk berdasarkan ID untuk menghapus gambar
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   // Menghapus gambar produk dari folder
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
   // Menghapus produk dari database
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   // Menghapus produk dari keranjang dan wishlist
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   // Mengalihkan kembali ke halaman produk setelah penghapusan
   header('location:products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Produk</title>

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

<section class="add-products">

   <h1 class="heading">Tambahkan Produk</h1>

   <!-- Form untuk menambahkan produk baru -->
   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Nama Produk (wajib)</span>
            <input type="text" class="box" required maxlength="100" placeholder="masukkan nama produk" name="name">
         </div>
         <div class="inputBox">
            <span>Harga Produk (wajib)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="masukkan harga produk" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
         <div class="inputBox">
            <span>Gambar 01 (wajib)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
         </div>
         <div class="inputBox">
            <span>Gambar 02 (wajib)</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
         </div>
         <div class="inputBox">
            <span>Gambar 03 (wajib)</span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
         </div>
         <div class="inputBox">
            <span>Detail Produk (wajib)</span>
            <textarea name="details" placeholder="masukkan detail produk" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      
      <input type="submit" value="Tambahkan Produk" class="btn" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">Produk Ditambahkan</h1>

   <div class="box-container">

   <?php
      // Mengambil dan menampilkan semua produk dari database
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
      <div class="details"><span><?= $fetch_products['details']; ?></span></div>
      <div class="flex-btn">
         <!-- Tombol untuk memperbarui produk -->
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Perbarui</a>
         <!-- Tombol untuk menghapus produk dengan konfirmasi -->
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('hapus produk ini?');">Hapus</a>
      </div>
   </div>
   <?php
         }
      }else{
         // Pesan jika belum ada produk yang ditambahkan
         echo '<p class="empty">belum ada produk yang ditambahkan!</p>';
      }
   ?>
   
   </div>

</section>

<!-- Menyertakan skrip JavaScript








<script src="../js/admin_script.js"></script>
   
</body>
</html>