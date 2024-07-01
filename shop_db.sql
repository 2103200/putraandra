-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
-- 
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2022 at 12:51 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

-- Mengatur mode SQL
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- Memulai transaksi
START TRANSACTION;

-- Mengatur zona waktu
SET time_zone = "+00:00";

-- Menyimpan pengaturan lama untuk karakter set dan collation
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

-- Mengatur karakter set ke utf8mb4
/*!40101 SET NAMES utf8mb4 */;

-- 
-- Database: `shop_db`
-- 

-- --------------------------------------------------------

-- 
-- Struktur tabel untuk tabel `admins`
-- 

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 
-- Memasukkan data ke tabel `admins`
-- 

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

-- 
-- Struktur tabel untuk tabel `cart`
-- 

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- 
-- Struktur tabel untuk tabel `messages`
-- 

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- 
-- Struktur tabel untuk tabel `orders`
-- 

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- 
-- Struktur tabel untuk tabel `products`
-- 

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- 
-- Struktur tabel untuk tabel `users`
-- 

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- 
-- Struktur tabel untuk tabel `wishlist`
-- 

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 
-- Indeks untuk tabel yang telah di-dump
-- 

-- 
-- Indeks untuk tabel `admins`
-- 
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

-- 
-- Indeks untuk tabel `cart`
-- 
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

-- 
-- Indeks untuk tabel `messages`
-- 
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

-- 
-- Indeks untuk tabel `orders`
-- 
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

-- 
-- Indeks untuk tabel `products`
-- 
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

-- 
-- Indeks untuk tabel `users`
-- 
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

-- 
-- Indeks untuk tabel `wishlist`
-- 
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

-- 
-- AUTO_INCREMENT untuk tabel yang telah di-dump
-- 

-- 
-- AUTO_INCREMENT untuk tabel `admins`
-- 
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- 
-- AUTO_INCREMENT untuk tabel `cart`
-- 
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT untuk tabel `messages`
-- 
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT untuk tabel `orders`
-- 
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT untuk tabel `products`
-- 
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT untuk tabel `users`
-- 
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

-- 
-- AUTO_INCREMENT untuk tabel `wishlist`
-- 
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

-- Menyelesaikan transaksi
COMMIT;

-- Mengembalikan pengaturan karakter set dan collation ke nilai sebelumnya
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
