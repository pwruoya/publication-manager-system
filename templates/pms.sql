-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 24, 2024 at 12:55 AM
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
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `isbn` varchar(13) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `publication_date` date DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contributor`
--

CREATE TABLE `contributor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_info` text NOT NULL,
  `role` enum('Author','Editor','Publisher') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contributor`
--

INSERT INTO `contributor` (`id`, `name`, `email`, `contact_info`, `role`) VALUES
(1, 'Martin Luther', 'luther@gmail.com', '254 7165262534', 'Author'),
(2, 'lois lane', 'lane@gmail.com', '254 546764324', 'Editor'),
(3, 'Clark Kent', 'kent@gmail.com', '254 765123', 'Publisher'),
(4, 'peptang', 'pep@gmail.com', '254 7890786', 'Author'),
(5, 'Rashford', 'rashy9@gmail.com', '254 7165262534', 'Author'),
(6, 'Ken Walibora', 'walibora@gmail.com', '254 780765324', 'Author'),
(7, 'Bruce Wayne', 'wayne@gmail.com', '254 75645364', 'Editor'),
(8, 'Dianna Prince', 'diana@gmail.com', '254 65776534', 'Publisher'),
(9, 'Steve Rodgers', 'steve@gmail.com', '254 787654132', 'Author'),
(10, 'Tony Stark', 'stark@gmail.com', '254712635463', 'Editor'),
(11, 'Bruce Banner', 'banner@gmail.com', '254 765987546', 'Publisher');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manuscripts`
--

CREATE TABLE `manuscripts` (
  `manuscript_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `submission_date` date DEFAULT NULL,
  `status` enum('Pending','Reviewed','Published') DEFAULT 'Pending',
  `author_id` int(11) DEFAULT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `submitted_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manuscripts`
--

INSERT INTO `manuscripts` (`manuscript_id`, `title`, `submission_date`, `status`, `author_id`, `editor_id`, `submitted_date`, `due_date`, `remarks`) VALUES
(5, 'The River Between', '0000-00-00', 'Reviewed', 4, 2, '2024-08-24', '2024-08-31', 'Seems nice'),
(6, 'The Tropics', '0000-00-00', '', 4, 2, '2024-08-24', '2024-09-01', 'Very long'),
(11, 'Nike For Today', '2024-08-24', '', 1, 2, '2024-08-24', '2024-08-30', 'now'),
(12, 'Nike For Today', '2024-08-24', 'Pending', 1, 2, '2024-08-24', '2024-08-30', 'now'),
(13, 'Nike For Today', '2024-08-24', 'Pending', 1, 2, '2024-08-24', '2024-08-30', 'now'),
(19, 'The Avengers Initiative', '2024-08-24', 'Pending', 9, 10, '2024-08-24', '2024-08-31', 'okay ');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_status` enum('Pending','Shipped','Delivered') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `manuscript_id` int(11) DEFAULT NULL,
  `editor_id` int(11) DEFAULT NULL,
  `review_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `royalty_payments`
--

CREATE TABLE `royalty_payments` (
  `payment_id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `payment_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `book_id` int(11) DEFAULT NULL,
  `sale_date` date NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `sales_channel` varchar(100) DEFAULT NULL,
  `revenue_generated` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('Author','Editor','Publisher') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`) VALUES
(1, 'sanjay', 'sanjay@gmail.com', '$2y$10$g9BjRQb8VHWZjV9tosQBfeThM/l5BImtpLkQapH.mmv183uot1wS6', 'Author'),
(2, 'sanjay', 'sanjay@gmail.com', '$2y$10$Bz5Advu.rEsjd0Y8Fo7C3egS57OmJ2Bkyy9uQhSZ15PHV5ZOxgrdu', 'Author'),
(3, 'rashford', 'rashford@gmail.com', '$2y$10$2dfyFXtBwzcuLSGMih9Uuui24SkD5paZbHmu9K4uLB7RRA3VkgQZa', 'Author'),
(4, 'martin', 'marto@gmail.com', '$2y$10$iSbkvdKEwo81EE43uMtykuPu1/V3G7dJSqcb8qBy6naP2RQ707ZC6', 'Author');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `editor_id` (`editor_id`),
  ADD KEY `publisher_id` (`publisher_id`);

--
-- Indexes for table `contributor`
--
ALTER TABLE `contributor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `manuscripts`
--
ALTER TABLE `manuscripts`
  ADD PRIMARY KEY (`manuscript_id`),
  ADD KEY `fk_author` (`author_id`),
  ADD KEY `fk_editor` (`editor_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `manuscript_id` (`manuscript_id`),
  ADD KEY `editor_id` (`editor_id`);

--
-- Indexes for table `royalty_payments`
--
ALTER TABLE `royalty_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contributor`
--
ALTER TABLE `contributor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manuscripts`
--
ALTER TABLE `manuscripts`
  MODIFY `manuscript_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `royalty_payments`
--
ALTER TABLE `royalty_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`editor_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`publisher_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `manuscripts`
--
ALTER TABLE `manuscripts`
  ADD CONSTRAINT `fk_author` FOREIGN KEY (`author_id`) REFERENCES `contributor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_editor` FOREIGN KEY (`editor_id`) REFERENCES `contributor` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`manuscript_id`) REFERENCES `manuscripts` (`manuscript_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`editor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `royalty_payments`
--
ALTER TABLE `royalty_payments`
  ADD CONSTRAINT `royalty_payments_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `royalty_payments_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
