-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2026 at 05:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pwl_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `mentor_comments`
--

CREATE TABLE `mentor_comments` (
  `id` int NOT NULL,
  `mentor_user_id` int NOT NULL,
  `student_user_id` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mentor_comments`
--

INSERT INTO `mentor_comments` (`id`, `mentor_user_id`, `student_user_id`, `comment`, `created_at`) VALUES
(1, 6, 7, 'tes1', '2026-04-30 06:24:43'),
(2, 6, 8, '123', '2026-04-30 06:25:23'),
(3, 6, 8, 'keren bagus', '2026-04-30 06:25:53'),
(4, 6, 10, 'mantap men', '2026-05-05 05:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `mentor_profiles`
--

CREATE TABLE `mentor_profiles` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `skill_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `experience` text,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `feedback` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mentor_profiles`
--

INSERT INTO `mentor_profiles` (`id`, `user_id`, `skill_id`, `full_name`, `email`, `phone`, `address`, `experience`, `status`, `feedback`) VALUES
(1, 4, 1, 'budi.spd', 'mentor1@gmail.com', '082112331', NULL, '213', 'rejected', 'kamu bot'),
(2, 5, 2, 'fkmjsdnkj', 'dasd@gmail.com', '08213123', NULL, '123123', 'rejected', 'ebot si'),
(3, 6, 1, 'tes1', '123@123', '0812312321', NULL, 's', 'approved', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `session_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `recipient_id` int NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `mentor_id` int NOT NULL,
  `skill_id` int NOT NULL,
  `session_date` datetime NOT NULL,
  `status` enum('pending','confirmed','rejected','completed') NOT NULL DEFAULT 'pending',
  `notes` text,
  `meeting_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `student_id`, `mentor_id`, `skill_id`, `session_date`, `status`, `notes`, `meeting_link`) VALUES
(1, 7, 6, 1, '2026-04-16 22:41:00', 'pending', '123', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `description`) VALUES
(1, 'Web Development', 'Membangun aplikasi website dari frontend dan backend.'),
(2, 'Desain Grafis', 'Menggambar dan membuat desain visual menggunakan alat digital.'),
(3, 'Digital Marketing', 'Pemasaran produk atau jasa menggunakan media digital.'),
(4, 'Bahasa Inggris', 'Keterampilan berbicara, membaca, dan menulis bahasa Inggris.'),
(5, 'Public Speaking', 'Keterampilan berbicara di depan umum dan presentasi.');

-- --------------------------------------------------------

--
-- Table structure for table `skill_exchanges`
--

CREATE TABLE `skill_exchanges` (
  `id` int NOT NULL,
  `requester_id` int NOT NULL,
  `provider_id` int NOT NULL,
  `student_skill_id` int NOT NULL,
  `message` text,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_notes`
--

CREATE TABLE `student_notes` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `category` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_profiles`
--

CREATE TABLE `student_profiles` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `interest` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `student_profiles`
--

INSERT INTO `student_profiles` (`id`, `user_id`, `full_name`, `email`, `phone`, `address`, `interest`) VALUES
(1, 2, 'Harry Vanssa', 'harvy.zeus36@gmail.com', '085498987987', '8fwwfw', 'Tertarik pada: tech dan communication'),
(2, 3, 'asdwe', 'budi12@gmail.com', '08121321321', 'daew', NULL),
(3, 7, 'tes2', '123@123', '123321', '123123', 'Tertarik pada: creative dan intuitive'),
(4, 8, 'tes3', '123@123', '1234', '1234', 'Tertarik pada: speaking dan logical'),
(5, 9, 'tes4', '123@123', '123124', 'dlsfjilo', NULL),
(6, 10, 'tes5', '123@123', '123321', 'peojw', 'Tertarik pada: creative dan logical');

-- --------------------------------------------------------

--
-- Table structure for table `student_skills`
--

CREATE TABLE `student_skills` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `skill_id` int NOT NULL,
  `level` enum('beginner','intermediate','advanced') NOT NULL DEFAULT 'beginner',
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','student','mentor') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-03-17 12:56:53'),
(2, 'budi_1', '$2y$10$vdkX82l58NbroGUHda.mgORQELFnGCduYtYcwlCpv/MiInCyVJqL2', 'student', '2026-03-19 09:27:00'),
(3, 'budi_2', '$2y$10$V9DxWfVyp5gjZD7gglNvm.Ey03AmkNVdJiAjWy4xaA95b2iR4jUVm', 'student', '2026-03-19 10:35:26'),
(4, 'budi_3', '$2y$10$Ftvmy4rp2L3d/Cf4g0vmsOwKOlxkvVZcygm30RljMXmy6nx91oStG', 'mentor', '2026-03-19 10:36:37'),
(5, 'budi_4', '$2y$10$jzK0yRbnBnbwRT9WfHS7uedPI1QTW7W70RHE.jsYqggeWu63aShn.', 'mentor', '2026-03-19 10:37:55'),
(6, 'tes1', '$2y$10$q.F6iSR/XU4bGH.Dyl.eGeMZ7/a.EEkGYjsL.sQbzwksDH/905OFm', 'mentor', '2026-04-29 13:36:05'),
(7, 'tes2', '$2y$10$6u0S./PPe7Pijp.etp89FOHOzgQjBjsindADGN9ZOJS.y5mqsaZTK', 'student', '2026-04-29 13:37:27'),
(8, 'tes3', '$2y$10$QY7oyc2QBcnzvtvT2KYqlODSFKdrEzTtC5uEGBsUzGgRv2LC4GWOu', 'student', '2026-04-30 06:24:25'),
(9, 'tes4', '$2y$10$DT092Lg5s0vy90at/0m4EubVhQk.aBpJVg0dQAyhIIF7lyk88IyuS', 'student', '2026-05-05 05:16:08'),
(10, 'tes5', '$2y$10$JDgJZFdVbS.M2q.hIzAenOCbuj8S7KWJt.Uuv2p9LcGCEEtZ9s/ie', 'student', '2026-05-05 05:17:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mentor_comments`
--
ALTER TABLE `mentor_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mentor_user_id` (`mentor_user_id`),
  ADD KEY `student_user_id` (`student_user_id`);

--
-- Indexes for table `mentor_profiles`
--
ALTER TABLE `mentor_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `recipient_id` (`recipient_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `mentor_id` (`mentor_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `skill_exchanges`
--
ALTER TABLE `skill_exchanges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requester_id` (`requester_id`),
  ADD KEY `provider_id` (`provider_id`),
  ADD KEY `student_skill_id` (`student_skill_id`);

--
-- Indexes for table `student_notes`
--
ALTER TABLE `student_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `student_skills`
--
ALTER TABLE `student_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mentor_comments`
--
ALTER TABLE `mentor_comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mentor_profiles`
--
ALTER TABLE `mentor_profiles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `skill_exchanges`
--
ALTER TABLE `skill_exchanges`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_notes`
--
ALTER TABLE `student_notes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_profiles`
--
ALTER TABLE `student_profiles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `student_skills`
--
ALTER TABLE `student_skills`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mentor_comments`
--
ALTER TABLE `mentor_comments`
  ADD CONSTRAINT `fk_mc_mentor` FOREIGN KEY (`mentor_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_mc_student` FOREIGN KEY (`student_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mentor_profiles`
--
ALTER TABLE `mentor_profiles`
  ADD CONSTRAINT `fk_mentor_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_mentor_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_msg_recipient` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_msg_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_msg_session` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `fk_session_mentor` FOREIGN KEY (`mentor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_session_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_session_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `skill_exchanges`
--
ALTER TABLE `skill_exchanges`
  ADD CONSTRAINT `fk_ex_provider` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ex_requester` FOREIGN KEY (`requester_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ex_skill` FOREIGN KEY (`student_skill_id`) REFERENCES `student_skills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_notes`
--
ALTER TABLE `student_notes`
  ADD CONSTRAINT `fk_note_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD CONSTRAINT `fk_student_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_skills`
--
ALTER TABLE `student_skills`
  ADD CONSTRAINT `fk_ss_skill` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ss_student` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
