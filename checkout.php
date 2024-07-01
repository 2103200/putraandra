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
   header('location:user_login.php'); // Alihkan ke halaman login
}

// Memeriksa apakah form order telah dikirim
if(isset($_POST['order'])){

   // Mengambil dan membersihkan data dari form
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .', '. $_POST['street'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   // Memeriksa apakah keranjang belanja pengguna ada
   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   // Jika ada item dalam keranjang
   if($check_cart->rowCount() > 0){

      // Memasukkan pesanan baru ke dalam tabel orders
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      // Menghapus semua item dari keranjang pengguna
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'pesanan berhasil ditempatkan!'; // Pesan berhasil
   }else{
      $message[] = 'keranjang Anda kosong'; // Pesan jika keranjang kosong
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Untuk kompatibilitas dengan IE -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
   <title>checkout</title> <!-- Judul halaman -->
   
   <!-- Menghubungkan font awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Menghubungkan CSS kustom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Menghubungkan header pengguna -->
<?php include 'components/user_header.php'; ?>

<!-- Bagian pesanan checkout -->
<section class="checkout-orders">

   <form action="" method="POST"> <!-- Form untuk mengirim pesanan -->

   <h3>pesanan Anda</h3> <!-- Judul bagian pesanan -->

      <div class="display-orders">

      <?php
         $grand_total = 0; // Inisialisasi total keseluruhan
         $cart_items[] = ''; // Inisialisasi array item keranjang
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?"); // Memilih item dari keranjang pengguna
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - '; // Mengisi item keranjang
               $total_products = implode($cart_items); // Menggabungkan item keranjang
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']); // Menghitung total keseluruhan
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '$'.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p> <!-- Menampilkan item dalam keranjang -->
      <?php
            }
         }else{
            echo '<p class="empty">keranjang Anda kosong!</p>'; // Pesan jika keranjang kosong
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>"> <!-- Menyimpan total produk sebagai input tersembunyi -->
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>"> <!-- Menyimpan total harga sebagai input tersembunyi -->
         <div class="grand-total">hasil akhir :<span>$<?= $grand_total; ?>/-</span></div> <!-- Menampilkan total keseluruhan -->
      </div>

      <h3>tempatkan pesanan Anda</h3> <!-- Judul bagian tempatkan pesanan -->

      <div class="flex">
         <div class="inputBox">
            <span>Nama Anda :</span>
            <input type="text" name="name" placeholder="masukkan nama anda" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Nomor handphone anda :</span>
            <input type="number" name="number" placeholder="masukkan No. handphone" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>Email Anda :</span>
            <input type="email" name="email" placeholder="masukkan email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Metode Pembayaran :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">Cash On Delivery(COD)</option>
               <option value="credit card">credit card</option>
               <option value="paytm">paylater</option>
               <option value="paypal">tranfer akun virtual</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Provinsi :</span>
            <input type="text" name="flat" placeholder="masukkan provinsi" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Kota atau kabupaten :</span>
            <input type="text" name="street" placeholder="masukkan kota atau kabupaten" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>kecamatan :</span>
            <input type="text" name="city" placeholder="masukkan kecamatan" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Alamat :</span>
            <input type="text" name="state" placeholder="masukkan alamat" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Detail :</span>
            <input type="text" name="country" placeholder="masukkan detai (blok, lantai, dan lain-lain)" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Jumlah Barang :</span>
            <input type="number" min="0" name="pin_code" placeholder="masukkan jumlah barang" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order"> <!-- Tombol untuk mengirim pesanan -->

   </form>

</section>

<!-- Menghubungkan footer -->
<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script> <!-- Menghubungkan script kustom -->

</body>
</html>
