<?php
   // Cek apakah variabel $message sudah diset
   if(isset($message)){
      // Loop melalui setiap pesan dalam array $message
      foreach($message as $message){
         // Menampilkan pesan dalam elemen div dengan tombol close (x)
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

   <section class="flex">

      <!-- Logo dan tautan menuju halaman home -->
      <a href="home.php" class="logo">TUKU<span></span></a>

      <!-- Navigasi utama website -->
      <nav class="navbar">
         <a href="home.php">home</a>
         <a href="about.php">about</a>
         <a href="orders.php">orders</a>
         <a href="shop.php">shop</a>
         <a href="contact.php">contact</a>
      </nav>

      <div class="icons">
         <?php
            // Menghitung jumlah item dalam wishlist pengguna
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();

            // Menghitung jumlah item dalam cart pengguna
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <!-- Ikon menu, pencarian, wishlist, dan cart -->
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-search"></i></a>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php          
            // Mengambil data profil pengguna dari database
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            // Jika profil pengguna ditemukan
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <!-- Menampilkan nama pengguna dan tautan untuk update profil -->
         <p><?= $fetch_profile["name"]; ?></p>
         <a href="update_user.php" class="btn">update profile</a>
         <div class="flex-btn">
            <a href="user_register.php" class="option-btn">register</a>
            <a href="user_login.php" class="option-btn">login</a>
         </div>
         <!-- Tautan untuk logout dengan konfirmasi -->
         <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
         <?php
            } else {
         ?>
         <!-- Pesan jika pengguna belum login atau mendaftar -->
         <p>please login or register first!</p>
         <div class="flex-btn">
            <a href="user_register.php" class="option-btn">register</a>
            <a href="user_login.php" class="option-btn">login</a>
         </div>
         <?php
            }
         ?>      
      </div>

   </section>

</header>
