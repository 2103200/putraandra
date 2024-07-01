```php
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

// Memeriksa apakah form pembaruan telah disubmit
if(isset($_POST['update'])){

   // Mendapatkan data produk dari form
   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   // Memperbarui data produk di database
   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
   $update_product->execute([$name, $price, $details, $pid]);

   // Menambahkan pesan sukses
   $message[] = 'produk berhasil diperbarui!';

   // Mendapatkan data gambar lama dan baru
   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   // Memeriksa dan memperbarui gambar 01 jika diunggah
   if(!empty($image_01)){
      if($image_size_01 > 2000000){
         $message[] = 'ukuran gambar terlalu besar!';
      }else{
         // Memperbarui data gambar di database
         $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$image_01, $pid]);
         // Memindahkan gambar baru ke folder upload dan menghapus gambar lama
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_image_01);
         $message[] = 'gambar 01 berhasil diperbarui!';
      }
   }

   // Proses yang sama diulang untuk gambar 02
   $old_image_02 = $_POST['old_image_02'];
   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   if(!empty($image_02)){
      if($image_size_02 > 2000000){
         $message[] = 'ukuran gambar terlalu besar!';
      }else{
         $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
         $update_image_02->execute([$image_02, $pid]);
         move_uploaded_file($image_tmp_name_02, $image_folder_02);
         unlink('../uploaded_img/'.$old_image_02);
         $message[] = 'gambar 02 berhasil diperbarui!';
      }
   }

   // Proses yang sama diulang untuk gambar 03
   $old_image_03 = $_POST['old_image_03'];
   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   if(!empty($image_03)){
      if($image_size_03 > 2000000){
         $message[] = 'ukuran gambar terlalu besar!';
      }else{
         $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
         $update_image_03->execute([$image_03, $pid]);
         move_uploaded_file($image_tmp_name_03, $image_folder_03);
         unlink('../uploaded_img/'.$old_image_03);
         $message[] = 'gambar 03 berhasil diperbarui!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Perbarui Produk</title>

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

<section class="update-product">

   <h1 class="heading">Perbarui Produk</h1>

   <?php
      // Mendapatkan ID produk dari URL
      $update_id = $_GET['update'];
      // Memilih data produk berdasarkan ID
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      // Memeriksa apakah ada produk yang ditemukan
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <!-- Form untuk memperbarui produk -->
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
      <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
         </div>
         <div class="sub-image">
            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
         </div>
      </div>
      <!-- Input untuk memperbarui nama produk -->
      <span>Perbarui Nama</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="masukkan nama produk" value="<?= $fetch_products['name']; ?>">
      <!-- Input untuk memperbarui harga produk -->
      <span>Perbarui Harga</span>
      <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="masukkan harga produk" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">
      <!-- Input untuk memperbarui detail produk -->
      <span>Perbarui Detail</span>
      <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
      <!-- Input untuk memperbarui gambar 01 -->
      <span>Perbarui Gambar 01</span>
      <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <!-- Input untuk memperbarui gambar 02 -->
      <span>Perbarui Gambar 02</span>
      <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <!-- Input untuk memperbarui gambar 03 -->
      <span>Perbarui Gambar 03</span>
      <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <div class="flex-btn">
         <!-- Tombol untuk submit pembaruan -->
         <input type="submit" name="update" class="btn" value="Perbarui">
         <!-- Tombol untuk kembali ke halaman produk -->
         <a href="products.php" class="option-btn">Kembali</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         // Menampilkan pesan jika tidak ada produk yang ditemukan
         echo '<p class="empty">tidak ada produk yang ditemukan!</p>';
      }
   ?>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
```