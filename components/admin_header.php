<?php
   // Memeriksa apakah variabel $message ada
   if(isset($message)){
      // Menampilkan setiap pesan dalam variabel $message
      foreach($message as $message){
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

      <!-- Logo dan tautan ke dashboard admin -->
      <a href="../admin/dashboard.php" class="logo">My<span>Admin</span></a>

      <!-- Navigasi menu admin -->
      <nav class="navbar">
         <a href="../admin/dashboard.php">home</a>
         <a href="../admin/products.php">products</a>
         <a href="../admin/placed_orders.php">orders</a>
         <a href="../admin/admin_accounts.php">admins</a>
         <a href="../admin/users_accounts.php">users</a>
         <a href="../admin/messages.php">pesan</a>
      </nav>

      <!-- Ikon menu dan pengguna -->
      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <!-- Profil pengguna -->
      <div class="profile">
         <?php
            // Mengambil informasi profil admin dari database
            $select_profile = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <!-- Menampilkan nama pengguna admin -->
         <p><?= $fetch_profile['name']; ?></p>
         <!-- Tautan untuk memperbarui profil -->
         <a href="../admin/update_profile.php" class="btn">update profile</a>
         <div class="flex-btn">
            <!-- Tautan untuk mendaftar admin baru dan login -->
            <a href="../admin/register_admin.php" class="option-btn">register</a>
            <a href="../admin/admin_login.php" class="option-btn">login</a>
         </div>
         <!-- Tautan untuk logout -->
         <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('keluar dari situs web?');">logout</a> 
      </div>

   </section>

</header>
