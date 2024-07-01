<?php

// Menghubungkan ke file connect.php yang berisi konfigurasi koneksi ke database
include 'components/connect.php';

// Memulai sesi PHP untuk melacak sesi pengguna
session_start();

// Mengecek apakah sesi user_id telah diatur, jika ya, mengambil nilai user_id dari sesi
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   // Jika tidak ada sesi user_id, mengatur user_id menjadi string kosong
   $user_id = '';
};

// Mengecek apakah form telah disubmit
if(isset($_POST['submit'])){

   // Mengambil dan menyaring data email dari form
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   
   // Mengambil dan menyaring data password dari form, kemudian meng-hash password dengan SHA1
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   // Menyiapkan pernyataan SQL untuk memilih pengguna berdasarkan email dan password
   $select_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
   // Menjalankan pernyataan SQL yang telah disiapkan
   $select_user->execute([$email, $pass]);
   // Mengambil hasil query sebagai array asosiatif
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   // Mengecek apakah pengguna ditemukan dalam database
   if($select_user->rowCount() > 0){
      // Mengatur sesi user_id berdasarkan id pengguna yang ditemukan
      $_SESSION['user_id'] = $row['id'];
      // Mengarahkan pengguna ke halaman home.php
      header('location:home.php');
   }else{
      // Menambahkan pesan kesalahan jika email atau password salah
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   
   <!-- Menyertakan link CDN untuk font awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Menyertakan file CSS kustom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Menyertakan file user_header.php yang berisi header pengguna -->
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>login sekarang</h3>
      <!-- Input untuk email pengguna -->
      <input type="email" name="email" required placeholder="masukkan email Anda" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk password pengguna -->
      <input type="password" name="pass" required placeholder="masukkan password Anda" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Tombol submit untuk login -->
      <input type="submit" value="login now" class="btn" name="submit">
      <!-- Pesan jika pengguna tidak memiliki akun -->
      <p>tidak memiliki akun?</p>
      <!-- Link untuk menuju halaman pendaftaran pengguna -->
      <a href="user_register.php" class="option-btn">Daftar sekarang</a>
   </form>

</section>

<!-- Menyertakan file footer.php yang berisi footer situs -->
<?php include 'components/footer.php'; ?>

<!-- Menyertakan file JavaScript kustom -->
<script src="js/script.js"></script>

</body>
</html>