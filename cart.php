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
   header('location:user_login.php'); // Alihkan pengguna ke halaman login
}

// Memeriksa apakah form 'delete' dikirim
if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id']; // Ambil cart_id dari form
   // Siapkan dan eksekusi query untuk menghapus item dari keranjang berdasarkan id
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

// Memeriksa apakah parameter 'delete_all' ada di URL
if(isset($_GET['delete_all'])){
   // Siapkan dan eksekusi query untuk menghapus semua item dari keranjang berdasarkan user_id
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php'); // Alihkan pengguna ke halaman keranjang
}

// Memeriksa apakah form 'update_qty' dikirim
if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id']; // Ambil cart_id dari form
   $qty = $_POST['qty']; // Ambil qty dari form
   $qty = filter_var($qty, FILTER_SANITIZE_STRING); // Sanitasi qty
   // Siapkan dan eksekusi query untuk memperbarui jumlah item di keranjang
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'jumlah keranjang diperbarui'; // Tambahkan pesan ke array $message
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Untuk kompatibilitas dengan IE -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
   <title>Keranjang Shopping</title> <!-- Judul halaman -->

   <!-- Menghubungkan font awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Menghubungkan CSS kustom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Menghubungkan header pengguna -->
<?php include 'components/user_header.php'; ?>

<!-- Bagian keranjang shopping -->
<section class="products shopping-cart">

   <h3 class="heading">Keranjang Shopping</h3> <!-- Judul keranjang -->

   <div class="box-container">

   <?php
      $grand_total = 0; // Inisialisasi total keseluruhan
      // Siapkan dan eksekusi query untuk memilih semua item di keranjang berdasarkan user_id
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      // Periksa apakah ada item di keranjang
      if($select_cart->rowCount() > 0){
         // Loop melalui setiap item di keranjang
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
   ?>
   <!-- Form untuk setiap item di keranjang -->
   <form action="" method="post" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>"> <!-- Hidden input untuk cart_id -->
      <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a> <!-- Link untuk quick view -->
      <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt=""> <!-- Gambar produk -->
      <div class="name"><?= $fetch_cart['name']; ?></div> <!-- Nama produk -->
      <div class="flex">
         <div class="price">$<?= $fetch_cart['price']; ?>/-</div> <!-- Harga produk -->
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>"> <!-- Input untuk jumlah -->
         <button type="submit" class="fas fa-edit" name="update_qty"></button> <!-- Tombol untuk memperbarui jumlah -->
      </div>
      <div class="sub-total"> sub total : <span>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div> <!-- Sub total -->
      <input type="submit" value="hapus item" onclick="return confirm('hapus ini dari keranjang?');" class="delete-btn" name="delete"> <!-- Tombol untuk menghapus item -->
   </form>
   <?php
   $grand_total += $sub_total; // Tambahkan sub total ke grand total
      }
   }else{
      echo '<p class="empty">keranjang Anda kosong</p>'; // Pesan jika keranjang kosong
   }
   ?>
   </div>

   <div class="cart-total">
      <p>hasil akhir : <span>$<?= $grand_total; ?>/-</span></p> <!-- Total keseluruhan -->
      <a href="shop.php" class="option-btn">lanjutkan Belanja</a> <!-- Tombol untuk melanjutkan belanja -->
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('hapus semua dari keranjang?');">hapus semua item</a> <!-- Tombol untuk menghapus semua item -->
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">lanjutkan ke pembayaran</a> <!-- Tombol untuk melanjutkan ke pembayaran -->
   </div>

</section>

<?php include 'components/footer.php'; ?> <!-- Menghubungkan footer -->

<script src="js/script.js"></script> <!-- Menghubungkan script kustom -->

</body>
</html>
