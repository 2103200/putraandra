<?php

// Jika tombol 'add_to_wishlist' ditekan
if(isset($_POST['add_to_wishlist'])){

   // Cek apakah user sudah login, jika tidak maka diarahkan ke halaman login
   if($user_id == ''){
      header('location:user_login.php');
   } else {
      // Mengambil dan menyaring data yang dikirim melalui form
      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);

      // Mengecek apakah produk sudah ada di wishlist
      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$name, $user_id]);

      // Mengecek apakah produk sudah ada di cart
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      // Menentukan pesan yang sesuai jika produk sudah ada di wishlist atau cart, atau menambahkan ke wishlist
      if($check_wishlist_numbers->rowCount() > 0){
         $message[] = 'already added to wishlist!';
      } elseif($check_cart_numbers->rowCount() > 0){
         $message[] = 'already added to cart!';
      } else {
         // Menambahkan produk ke wishlist
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
         $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
         $message[] = 'added to wishlist!';
      }
   }
}

// Jika tombol 'add_to_cart' ditekan
if(isset($_POST['add_to_cart'])){

   // Cek apakah user sudah login, jika tidak maka diarahkan ke halaman login
   if($user_id == ''){
      header('location:user_login.php');
   } else {
      // Mengambil dan menyaring data yang dikirim melalui form
      $pid = $_POST['pid'];
      $pid = filter_var($pid, FILTER_SANITIZE_STRING);
      $name = $_POST['name'];
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $price = $_POST['price'];
      $price = filter_var($price, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      // Mengecek apakah produk sudah ada di cart
      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
      $check_cart_numbers->execute([$name, $user_id]);

      // Menentukan pesan yang sesuai jika produk sudah ada di cart atau menambahkan ke cart
      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'already added to cart!';
      } else {
         // Mengecek apakah produk sudah ada di wishlist dan menghapusnya jika ada
         $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
         $check_wishlist_numbers->execute([$name, $user_id]);

         if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
            $delete_wishlist->execute([$name, $user_id]);
         }

         // Menambahkan produk ke cart
         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
         $message[] = 'added to cart!';
      }
   }
}

?>
