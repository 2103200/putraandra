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
}

// Memeriksa apakah form kirim pesan telah dikirim
if(isset($_POST['send'])){

   // Mengambil dan membersihkan data dari form
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   // Memeriksa apakah pesan yang sama sudah pernah dikirim sebelumnya
   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   // Jika pesan sudah pernah dikirim, tampilkan pesan peringatan
   if($select_message->rowCount() > 0){
      $message[] = 'sudah mengirim pesan!';
   }else{
      // Jika pesan belum pernah dikirim, masukkan pesan baru ke dalam tabel messages
      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'pesan berhasil terkirim!'; // Pesan berhasil terkirim
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Untuk kompatibilitas dengan IE -->
   <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Membuat halaman responsif -->
   <title>Kontak</title> <!-- Judul halaman -->
   
   <!-- Menghubungkan font awesome untuk ikon -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Menghubungkan CSS kustom -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- Menghubungkan header pengguna -->
<?php include 'components/user_header.php'; ?>

<!-- Bagian formulir kontak -->
<section class="contact">

   <form action="" method="post"> <!-- Form untuk mengirim pesan -->
      <h3>berhubungan</h3> <!-- Judul bagian kontak -->
      <input type="text" name="name" placeholder="masukkan nama Anda" required maxlength="20" class="box"> <!-- Input untuk nama -->
      <input type="email" name="email" placeholder="masukkan email Anda" required maxlength="50" class="box"> <!-- Input untuk email -->
      <input type="number" name="number" min="0" max="9999999999" placeholder="masukkan nomor Anda" required onkeypress="if(this.value.length == 10) return false;" class="box"> <!-- Input untuk nomor telepon -->
      <textarea name="msg" class="box" placeholder="masukkan pesan Anda" cols="30" rows="10"></textarea> <!-- Textarea untuk pesan -->
      <input type="submit" value="Kirim Pesan" name="send" class="btn"> <!-- Tombol untuk mengirim pesan -->
   </form>

</section>

<!-- Menghubungkan footer -->
<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script> <!-- Menghubungkan script kustom -->

</body>
</html>
