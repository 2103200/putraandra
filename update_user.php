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

   // Mengambil dan menyaring data nama dari form
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   
   // Mengambil dan menyaring data email dari form
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   // Menyiapkan pernyataan SQL untuk memperbarui nama dan email pengguna berdasarkan user_id
   $update_profile = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
   // Menjalankan pernyataan SQL yang telah disiapkan
   $update_profile->execute([$name, $email, $user_id]);

   // Mengatur nilai default untuk password kosong (hashed)
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   
   // Mengambil data password sebelumnya, lama, baru, dan konfirmasi password dari form
   $prev_pass = $_POST['prev_pass'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   // Mengecek apakah password lama adalah password kosong
   if($old_pass == $empty_pass){
      $message[] = 'silakan masukkan kata sandi lama !';
   }elseif($old_pass != $prev_pass){
      // Mengecek apakah password lama cocok dengan password sebelumnya
      $message[] = 'kata sandi lama tidak cocok!';
   }elseif($new_pass != $cpass){
      // Mengecek apakah password baru cocok dengan konfirmasi password
      $message[] = 'konfirmasi kata sandi tidak cocok !';
   }else{
      // Jika semua kondisi di atas terpenuhi, memperbarui password pengguna
      if($new_pass != $empty_pass){
         $update_admin_pass = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
         $update_admin_pass->execute([$cpass, $user_id]);
         $message[] = 'kata sandi berhasil diperbarui !';
      }else{
         $message[] = 'silakan masukkan kata sandi baru!';
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
   <title>register</title>
   
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
      <h3>memperbarui sekarang</h3>
      <!-- Menyimpan password sebelumnya dalam input tersembunyi -->
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
      <!-- Input untuk nama pengguna -->
      <input type="text" name="name" required placeholder="masukkan username Anda" maxlength="20"  class="box" value="<?= $fetch_profile["name"]; ?>">
      <!-- Input untuk email pengguna -->
      <input type="email" name="email" required placeholder="masukkan email Anda" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">
      <!-- Input untuk password lama -->
      <input type="password" name="old_pass" placeholder="masukkan kata sandi lama Anda" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk password baru -->
      <input type="password" name="new_pass" placeholder="masukkan kata sandi baru Anda" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Input untuk konfirmasi password baru -->
      <input type="password" name="cpass" placeholder="konfirmasikan kata sandi baru Anda" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <!-- Tombol submit untuk memperbarui profil -->
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

</section>

<!-- Menyertakan file footer.php yang berisi footer situs -->
<?php include 'components/footer.php'; ?>

<!-- Menyertakan file JavaScript kustom -->
<script src="js/script.js"></script>

</body>
</html>