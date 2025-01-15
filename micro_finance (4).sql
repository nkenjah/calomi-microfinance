-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 15, 2025 at 03:31 PM
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
-- Database: `micro_finance`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup_logs`
--

CREATE TABLE `backup_logs` (
  `id` int(11) NOT NULL,
  `backup_file` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `loan_amount` decimal(10,2) NOT NULL,
  `interest_rate` decimal(5,2) NOT NULL,
  `loan_duration` int(11) NOT NULL,
  `collateral` text DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `balance` decimal(10,2) DEFAULT 0.00,
  `client_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `phone`, `address`, `loan_amount`, `interest_rate`, `loan_duration`, `collateral`, `created_by`, `created_at`, `balance`, `client_image`) VALUES
(37, 'Emanuel frank mkenza ', '+255694995652', 'Tanzania, dar es salaam, Temeke, keko machungwa, dearles pub Block.32', 90000.00, 12.00, 12, 'dgus  tftytfy  tyrfyhdftyv wq', 'Emanuelmkenza007', '2024-12-31 10:05:15', 0.00, 'uploads/passport size emanuekl.jpg'),
(38, 'Emanuel frank mkenza', '0617375406', 'Tanzania', 50000.00, 12.00, 2, 'emanuel mkenza frank mkenza', 'emanuel@gmail.com', '2024-12-31 10:07:43', 0.00, 'uploads/passport size emanuekl.png'),
(39, 'Emanuel ', '0694995652', 'Tanzania, dar es salaam', 20000.00, 3.00, 4, 'oppopppo opooppo', 'Emanuelmkenza007', '2024-12-31 11:40:46', 0.00, 'uploads/IMG_20230824_164639_456.jpg'),
(40, 'emanuel mkenza', '0694995652', 'Tanzania, dar es salaam, Temeke, keko machungwa, dearles pub Block.32', 90000.00, 12.00, 2, '0', 'Emanuelmkenza007', '2025-01-11 20:46:51', 0.00, 'uploads/passport size emanuekl.jpg'),
(41, 'emanuel mkenza', '0694995652', 'Tanzania, dar es salaam, Temeke, keko machungwa, dearles pub Block.32', 9000000.00, 20.00, 6, '0', 'Emanuelmkenza007', '2025-01-13 10:49:01', 0.00, 'uploads/passport size emanuekl.png');

-- --------------------------------------------------------

--
-- Table structure for table `guarantors`
--

CREATE TABLE `guarantors` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `relationship` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `message` text NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `date`, `message`, `username`) VALUES
(6, '2025-01-20', 'hello programer', 'emanuel mkenza');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `phone`, `address`, `email`, `image`, `created_at`) VALUES
(21, 'nkenjah frank', '+255689132291', 'Tanzania', 'admin@gmail.com', 'uploads/passport size emanuekl.png', '2024-12-28 19:35:36');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `client_name` varchar(55) NOT NULL,
  `type` enum('loan','repayment') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `staff_username` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `status` enum('pending','confirmed') NOT NULL,
  `transaction_date` datetime DEFAULT current_timestamp(),
  `remaining_debt` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `client_name`, `type`, `amount`, `date`, `staff_username`, `created_by`, `status`, `transaction_date`, `remaining_debt`) VALUES
(74, '37', 'loan', 200000.00, '2025-01-11 21:47:15', '7', 'emanuel@gmail.com', '', '2025-01-11 13:47:15', 200000.00),
(75, '37', 'repayment', 50000.00, '2025-01-11 21:47:26', '7', 'emanuel@gmail.com', '', '2025-01-11 13:47:26', 150000.00),
(83, '40', 'loan', 10000000.00, '2025-01-13 10:43:09', '9', '', 'pending', '2025-01-13 02:43:09', 0.00),
(84, '40', 'repayment', 400000.00, '2025-01-13 10:43:37', '9', '', 'pending', '2025-01-13 02:43:37', 0.00),
(85, '40', 'loan', 9000000.00, '2025-01-13 10:44:35', '9', '', 'pending', '2025-01-13 02:44:35', 0.00),
(86, '40', 'repayment', 6000000.00, '2025-01-13 10:45:35', '9', '', 'pending', '2025-01-13 02:45:35', 0.00),
(87, '37', 'repayment', 900000.00, '2025-01-13 11:09:01', '9', 'Emanuelmkenza007', 'pending', '2025-01-13 03:09:01', -750000.00),
(88, '40', 'repayment', 800000.00, '2025-01-13 11:09:38', '9', 'Emanuelmkenza007', 'pending', '2025-01-13 03:09:38', -800000.00),
(89, '39', 'loan', 50000.00, '2025-01-13 11:09:50', '9', 'Emanuelmkenza007', 'pending', '2025-01-13 03:09:50', 50000.00),
(90, '39', 'repayment', 30000.00, '2025-01-13 11:10:04', '9', 'Emanuelmkenza007', 'pending', '2025-01-13 03:10:04', 20000.00),
(91, '39', 'repayment', 80000.00, '2025-01-13 13:28:45', '9', 'Emanuelmkenza007', 'pending', '2025-01-13 05:28:45', -60000.00),
(92, '37', 'repayment', 20000.00, '2025-01-15 09:22:54', '8', '', 'pending', '2025-01-15 01:22:54', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_attachment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `profile_attachment`) VALUES
(1, 'emanuelmkenza@gmail.com', '$2y$10$9WF1eF78n8jeY8hMrqVPsOS3ZZ1yLnO6w9O1xfxubEq4Chfo9L.I6', 'admin', '2024-12-18 20:38:19', ''),
(7, 'emanuel@gmail.com', '$2y$10$Xt8yvqoKCILqZRNfK1HSw.9RutG/qlAnX3fUXxsmmI.2pnzn7MRBm', 'staff', '2024-12-22 15:54:10', ''),
(11, 'nkenjah', '$2y$10$bXuM3r47aUDKngJSFfs2muPMgNfkiYhO.FmL1A6pW2zZtJPRrn9Ji', 'admin', '2025-01-15 08:06:23', ''),
(13, 'Emanuelmkenza007', '$2y$10$GMeAQmHeGOFAO/vZXZwucOhGbI7cLio95NJfvA5FgXMfT1n.zfwi2', 'staff', '2025-01-15 11:48:36', '6787bf4a093e9.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `website_info`
--

CREATE TABLE `website_info` (
  `id` int(11) NOT NULL,
  `header_title` varchar(255) NOT NULL,
  `hero_title` varchar(255) NOT NULL,
  `hero_subtitle` varchar(255) NOT NULL,
  `about_text` text NOT NULL,
  `mission_statement` text NOT NULL,
  `registration_info` text NOT NULL,
  `services_text` text NOT NULL,
  `loan_types` text NOT NULL,
  `services_note` text NOT NULL,
  `eligibility_intro` text NOT NULL,
  `eligibility_criteria` text NOT NULL,
  `contact_text` text NOT NULL,
  `phone_whatsapp` varchar(50) NOT NULL,
  `contact_social_media` text NOT NULL,
  `footer_copyright` text NOT NULL,
  `footer_social_links` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup_logs`
--
ALTER TABLE `backup_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `guarantors`
--
ALTER TABLE `guarantors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_id` (`staff_username`),
  ADD KEY `transactions_ibfk_1` (`client_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `website_info`
--
ALTER TABLE `website_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup_logs`
--
ALTER TABLE `backup_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `guarantors`
--
ALTER TABLE `guarantors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `website_info`
--
ALTER TABLE `website_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
