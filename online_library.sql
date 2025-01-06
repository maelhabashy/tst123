-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2025 at 02:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `bio`, `created_at`) VALUES
(1, 'J.K. Rowling', 'Author of the Harry Potter series.', '2025-01-01 08:06:39'),
(2, 'Stephen King', 'Master of horror and suspense.', '2025-01-01 08:06:39'),
(3, 'George Orwell', 'Author of 1984 and Animal Farm.', '2025-01-01 08:06:39'),
(4, 'Isaac Asimov', 'Pioneer of science fiction.', '2025-01-01 08:06:39'),
(5, 'J.R.R. Tolkien', 'Author of The Lord of the Rings.', '2025-01-01 08:06:39'),
(6, 'Anwar', 'Mohamed Anwar', '2025-01-01 09:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `publication_date` date DEFAULT NULL,
  `isbn` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author_id`, `category_id`, `description`, `image`, `created_at`, `publication_date`, `isbn`) VALUES
(1, 'Harry Potter and the Philosopher\'s Stone', 1, 5, 'The first book in the Harry Potter series.', 'harry_potter.jpg', '2025-01-01 08:06:51', '2013-07-17', 12321),
(3, '1984', 3, 1, 'A dystopian novel by George Orwell.', '1984.jpg', '2025-01-01 08:06:51', NULL, NULL),
(4, 'Foundation', 4, 3, 'A science fiction masterpiece by Isaac Asimov.', '470.jpg', '2025-01-01 08:06:51', '2014-03-06', 12321),
(5, 'The Lord of the Rings', 5, 5, 'An epic fantasy novel by J.R.R. Tolkien.', 'The Lord of the Rings.jpg', '2025-01-01 08:06:51', '1999-07-13', 12321),
(6, 'Animal Farm', 3, 1, 'A satirical allegory by George Orwell.', 'animal_farm.jpg', '2025-01-01 08:06:51', NULL, NULL),
(7, 'The Hobbit', 5, 5, 'A fantasy novel by J.R.R. Tolkien.', 'the_hobbit.jpg', '2025-01-01 08:06:51', NULL, NULL),
(8, 'I, Robot', 4, 3, 'A collection of science fiction stories by Isaac Asimov.', 'i_robot.jpg', '2025-01-01 08:06:51', NULL, NULL),
(9, 'The Stand', 2, 1, 'A post-apocalyptic horror novel by Stephen King.', 'the_stand.jpg', '2025-01-01 08:06:51', NULL, NULL),
(10, 'asas', 4, 1, 'asas', '', '2025-01-01 09:05:46', NULL, NULL),
(11, 'Anwar Book', 4, 5, 'asas', 'png-transparent-arab-academy-for-science-technology-maritime-transport-university-arab-league-arab-furniture-egypt-logo.png', '2025-01-01 09:07:11', NULL, NULL),
(12, 'anwar Book', 4, 5, 'assasas', '61+sHysvJ5L._AC_.jpg', '2025-01-01 09:15:51', NULL, NULL),
(13, 'Saif Story', 6, 6, 'Saif Story ', 'hill-climbing-algorithm-in-ai.png', '2025-01-01 11:47:16', '2025-01-09', 12321);

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `user_id`, `book_id`, `borrow_date`, `return_date`, `created_at`) VALUES
(1, 2, 1, '2025-10-01', '2025-10-15', '2025-01-01 08:06:59'),
(2, 2, 3, '2025-10-05', '0000-00-00', '2025-01-01 08:06:59'),
(3, 3, 5, '2025-10-10', '2025-10-20', '2025-01-01 08:06:59'),
(4, 3, 7, '2025-10-12', '0000-00-00', '2025-01-01 08:06:59'),
(5, 2, 3, '2025-01-08', '2025-01-22', '2025-01-01 10:10:20'),
(6, 4, 12, '2025-01-09', '0000-00-00', '2025-01-01 10:25:53'),
(7, 5, 5, '2025-01-24', '0000-00-00', '2025-01-01 10:56:58'),
(8, 5, 13, '2025-01-01', '2025-01-31', '2025-01-01 11:50:56'),
(9, 4, 13, '2025-01-01', '2025-01-15', '2025-01-01 12:01:34'),
(10, 4, 4, '2025-01-16', '2025-01-30', '2025-01-01 12:23:37');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Fiction', '2025-01-01 08:06:32'),
(2, 'Non-Fiction', '2025-01-01 08:06:32'),
(3, 'Science', '2025-01-01 08:06:32'),
(4, 'History', '2025-01-01 08:06:32'),
(5, 'Fantasy', '2025-01-01 08:06:32'),
(6, 'css', '2025-01-01 08:23:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-01-01 08:06:23'),
(2, 'user1', 'user1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '2025-01-01 08:06:23'),
(3, 'user2', 'user2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '2025-01-01 08:06:23'),
(4, 'anwar', 'anwar@cs.com', '$2y$10$5KDcY9uVC8S6iDjU5zZAQOXCDw3j7BtfPHVy8lTC6zxfZSE9izPge', 'admin', '2025-01-01 08:07:43'),
(5, 'saif', 'saif@anwar.com', '$2y$10$a3N8vbfg5JTVN6qex/TbBOD/ciF8Rq2mD5MO3VTn8OjnObML6ycKW', 'user', '2025-01-01 10:40:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
