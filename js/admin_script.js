// Mendapatkan elemen navbar dan profile dari DOM
let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');

// Menambahkan event listener untuk tombol menu
document.querySelector('#menu-btn').onclick = () => {
   // Mengaktifkan atau menonaktifkan kelas 'active' pada navbar
   navbar.classList.toggle('active');
   // Menghapus kelas 'active' dari profile
   profile.classList.remove('active');
}

// Menambahkan event listener untuk tombol pengguna
document.querySelector('#user-btn').onclick = () => {
   // Mengaktifkan atau menonaktifkan kelas 'active' pada profile
   profile.classList.toggle('active');
   // Menghapus kelas 'active' dari navbar
   navbar.classList.remove('active');
}

// Menghapus kelas 'active' dari navbar dan profile saat window di-scroll
window.onscroll = () => {
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

// Mendapatkan elemen gambar utama dan gambar-gambar kecil
let mainImage = document.querySelector('.update-product .image-container .main-image img');
let subImages = document.querySelectorAll('.update-product .image-container .sub-image img');

// Menambahkan event listener untuk setiap gambar kecil
subImages.forEach(images => {
   images.onclick = () => {
      // Mengambil atribut 'src' dari gambar yang diklik
      let src = images.getAttribute('src');
      // Mengubah 'src' gambar utama menjadi 'src' gambar yang diklik
      mainImage.src = src;
   }
});
