-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 13, 2026 at 09:36 AM
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
-- Database: `idiscuss`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(8) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_description` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `category_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_description`, `created`, `category_image`) VALUES
(1, 'Python', 'Python is a versatile, high-level programming language known for its simplicity and readability. It was created by Guido van Rossum in the late 1980s and officially released in 1991.', '2025-09-19 20:22:26', 'Python.jpg'),
(2, 'Java', 'Java is a high-level, object-oriented programming language developed by Sun Microsystems in 1995. It is widely used for building desktop applications, web applications, Android apps, and enterprise systems.', '2025-09-19 20:22:26', 'Java.jpg'),
(3, 'JavaScript', 'JavaScript is a versatile and powerful programming language that adds interactivity to websites. It is widely used for both client-side and server-side development, making it essential for modern web applications.', '2025-09-25 20:58:55', 'JavaScript.jpg'),
(4, 'PHP', 'PHP is a server scripting language, and a powerful tool for making dynamic and interactive Web pages.\r\nPHP is a widely used, free, and efficient alternative to competitors such as Microsoft\'s ASP.', '2025-09-25 20:58:55', 'PHP.jpg'),
(8, 'C', 'The C programming language is a foundational, general-purpose, procedural language developed in the early 1970s by Dennis Ritchie at Bell Labs, primarily for writing the Unix operating system.', '2026-01-19 15:54:34', 'C.jpg'),
(11, 'C++', 'C++ is a general-purpose programming language developed by Bjarne Stroustrup in 1979 as an extension of the C language. It combines features of both high-level and low-level programming, making it a middle-level language. ', '2026-03-20 21:12:34', 'C++.jpg'),
(12, 'Ruby', 'Ruby is an open-sourced, dynamic language designed with ease of use and productivity in mind. It has a very clean syntax that\'s easy to read and write.', '2026-03-20 21:29:00', 'Ruby.jpg'),
(13, 'Swift', 'Swift is a powerful, intuitive programming language for macOS, iOS, watchOS, and tvOS. Developing in Swift is interactive and fun; its syntax is concise yet expressive, and Swift includes modern features developers love.', '2026-03-20 21:42:57', 'Swift.jpg'),
(14, 'SQL', 'SQL is the language standard of relational database management and manipulation. It is, hence, a quite important tool in querying and managing databases applied to various aspects.', '2026-03-20 21:44:31', 'SQL.jpg'),
(15, 'Kotlin', 'Kotlin is a new statically typed programming language, meaning it\'s interoperable with Java. It aims at improving productivity and safety, with gradual penetration into Android development.', '2026-03-20 21:46:13', 'Kotlin.jpg'),
(16, 'TypeScript', 'TypeScript is a strongly typed superset of JavaScript that compiles to plain JavaScript. It adds static types to the language, which can improve code quality and maintainability.', '2026-03-20 22:00:44', 'TypeScript.jpg'),
(17, 'Perl', 'Perl is a high-level, general-purpose, interpreted language known for its text-processing capabilities. It is often used for system administration, web development, and network programming.', '2026-03-20 22:06:25', 'Perl.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(8) NOT NULL,
  `comment_content` text NOT NULL,
  `thread_id` int(8) NOT NULL,
  `comment_by` int(8) NOT NULL,
  `comment_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES
(28, 'Object Oriented Programming.', 18, 5, '2026-03-20 20:31:22'),
(29, 'Constraints are used to define rule on data in a table.', 35, 5, '2026-03-24 09:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(8) NOT NULL,
  `user_id` int(8) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `user_id`, `name`, `email`, `subject`, `message`, `created_at`, `status`) VALUES
(1, 5, 'Aditya', 'adity12@gmail.com', 'Login Issue', 'I am unable to login', '2026-03-25 10:50:44', 'Pending'),
(5, 16, 'Anupam', 'Anupam@gmail.com', 'Search', 'I am facing problem in searching threads.', '2026-03-25 11:21:11', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `thread`
--

CREATE TABLE `thread` (
  `thread_id` int(7) NOT NULL,
  `thread_title` varchar(255) NOT NULL,
  `thread_desc` text NOT NULL,
  `thread_cat_id` int(7) NOT NULL,
  `thread_user_id` int(7) NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thread`
--

INSERT INTO `thread` (`thread_id`, `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES
(6, '$_Server.', 'How can we use $_server in PHP?', 4, 3, '2025-09-27 09:15:36'),
(13, 'Tupple', 'What is tupple?', 1, 3, '2025-11-07 20:55:19'),
(18, 'Oops', 'What is oops ?', 1, 3, '2025-11-07 21:05:15'),
(32, 'Function', 'What is function ?', 5, 5, '2026-01-16 11:17:07'),
(33, 'C++ Friend Function', 'I am unable to understand the function of friend function.', 9, 5, '2026-02-11 20:26:26'),
(34, 'Features', 'Tell me some special features of java.', 1, 5, '2026-02-28 22:20:55'),
(35, 'Constraints', 'What is constraints ?', 14, 5, '2026-03-24 09:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `sno` int(8) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL,
  `role` varchar(10) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`sno`, `username`, `email`, `password`, `timestamp`, `role`) VALUES
(3, 'Apurv', 'apurv@gmail.com', '$2y$10$ed5jWnCCEm7w.FyPhk8CIeLJdTy6bvVDZN0aKhzZ9kM2FDkuIO/Aq', '2025-11-03 18:31:28', 'user'),
(4, 'Aarohi Roy', 'aarohi@gmail.com', '$2y$10$f3eXesyaof2NCoJS/obrkettK2PYqa9NKKP7lCCtORF6hQJKPd00u', '2025-11-12 21:34:51', 'user'),
(5, 'Aditya', 'adity12@gmail.com', '$2y$10$CnNTqV..ZeyJlQvc/zQJvO.cpDSWZwnETt0KM1jUKawboR/1Wnbl6', '2026-01-13 21:01:39', 'user'),
(9, 'Admin', 'admin123@gmail.com', '$2y$10$oV.y5zcVX4P8C/hWsYnlveDRAMF8wRVnKWR3XhXUOusxUSIieZHm2', '2026-01-13 22:36:00', 'admin'),
(14, 'Mona', 'mona1322@gmail.com', '$2y$10$nSrnDsgx5ZUKBYKY5sUdk.nsi.ufJWRDqq9RXaBwQS5Wu/Zn4vWIi', '0000-00-00 00:00:00', 'user'),
(15, 'Shivam', 'shivamrai457@gmail.com', '$2y$10$KNP2AfNlNxkT035OntzUxeB60qKpHlLi8VxeJZ435Ri5O0YkEyGVO', '2026-02-28 22:43:10', 'user'),
(16, 'Anupam', 'Anupam@gmail.com', '$2y$10$FltHefePmnwNuhgZMjMuOeGdvqGbhdyqNIO6GgAy7cYoNy1MEAYQG', '2026-03-24 21:04:18', 'user'),
(17, 'Bipin', 'sharmabipin0951@gmail.com', '$2y$10$RxF09zlKxESuo6hiPKoD3.jor/TPdFxYTwbl.ReVsjdYVaYmA8gMG', '2026-04-09 21:13:37', 'user'),
(18, 'Aman', 'aman123@gmail.com', '$2y$10$yc1msczXnu4NYZ8LG5t84uIgCAVxzQsbXysXpPfJEe/uQ7ywiyu5a', '0000-00-00 00:00:00', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`thread_id`);
ALTER TABLE `thread` ADD FULLTEXT KEY `thread_title` (`thread_title`,`thread_desc`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `thread`
--
ALTER TABLE `thread`
  MODIFY `thread_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `sno` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`sno`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
