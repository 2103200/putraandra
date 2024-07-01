<?php

// Menghubungkan file dengan 'connect.php' untuk koneksi database
include '../components/connect.php';

// Memulai sesi
session_start();

// Mengecek jika form dikirim
if(isset($_POST['submit'])){

   // Mengambil dan menyaring input username
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   
   // Mengambil dan mengenkripsi password
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   // Menyiapkan query untuk memeriksa admin dengan nama dan password yang sesuai
   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   // Jika admin ditemukan
   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id']; // Menyimpan id admin dalam sesi
      header('location:dashboard.php'); // Mengarahkan ke dashboard
   }else{
      // Menyimpan pesan kesalahan jika username atau password salah
      $message[] = 'Username atau kata sandi salah!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Metadata dan link CSS -->
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- Link ke Font Awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Link ke file CSS untuk admin -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php
   // Menampilkan pesan kesalahan jika ada
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i> <!-- Ikon untuk menghapus pesan -->
         </div>
         ';
      }
   }
?>

<section class="form-container">

   <form action="" method="post">
      <h3>Masuk sekarang</h3>
      <p>default username = <span>admin</span> & password = <span>111</span></p> <!-- Informasi login default -->
      <input type="text" name="name" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk username, membatasi panjang dan menghapus spasi -->
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk password, membatasi panjang dan menghapus spasi -->
      <input type="submit" value="Masuk sekarang" class="btn" name="submit"> <!-- Tombol submit untuk login -->
   </form>

</section>
   
</body>
</html>
