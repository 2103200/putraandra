// Memilih elemen navbar dan profile di dalam header
let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');

// Menambahkan event klik pada tombol menu
document.querySelector('#menu-btn').onclick = () => {
   // Menambah/menghapus kelas 'active' pada navbar
   navbar.classList.toggle('active');
   // Menghapus kelas 'active' dari profile
   profile.classList.remove('active');
}

// Menambahkan event klik pada tombol pengguna
document.querySelector('#user-btn').onclick = () => {
   // Menambah/menghapus kelas 'active' pada profile
   profile.classList.toggle('active');
   // Menghapus kelas 'active' dari navbar
   navbar.classList.remove('active');
}

// Menangani event saat halaman di-scroll
window.onscroll = () => {
   // Menghapus kelas 'active' dari navbar
   navbar.classList.remove('active');
   // Menghapus kelas 'active' dari profile
   profile.classList.remove('active');
}

// Memilih gambar utama dan gambar kecil di dalam kontainer gambar
let mainImage = document.querySelector('.quick-view .box .row .image-container .main-image img');
let subImages = document.querySelectorAll('.quick-view .box .row .image-container .sub-image img');

// Menambahkan event klik pada setiap gambar kecil
subImages.forEach(images => {
   images.onclick = () => {
      // Mengambil atribut 'src' dari gambar kecil yang diklik
      let src = images.getAttribute('src');
      // Mengganti 'src' gambar utama dengan 'src' gambar kecil yang diklik
      mainImage.src = src;
   }
});
