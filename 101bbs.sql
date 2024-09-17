-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2024-09-17 15:08:27
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `101bbs`
--

-- --------------------------------------------------------

--
-- 表的结构 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `lost_and_found` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `author` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `posts`
--

INSERT INTO `posts` (`id`, `title`, `text`, `image`, `lost_and_found`, `created_at`, `author`) VALUES
(20, 'I love holiday', 'holiday', 'WeChat Image_20230503215755.jpg', 0, '2024-09-16 02:36:06', 'cc'),
(23, 'I found something new', 'Le\'s dance', 'Dance.gif', 0, '2024-09-17 03:47:42', 'Jim'),
(24, 'Anyone want play frisbee Friday afternoon', '5PM', 'frisbee.gif', 0, '2024-09-17 04:10:41', 'Jim'),
(25, 'I lost my power bank', 'if you seen it, please reach me at class 23', '屏幕截图 2022-11-22 210555.png', 1, '2024-09-17 04:11:42', 'Amy'),
(26, 'We have Party next Friday', 'Dress code: Summer', 'party.gif', 0, '2024-09-17 04:12:16', 'Amy'),
(27, 'The football semi final will be happen in Wednesday afternoon', 'We need water, towel and your cheers.', 'football.gif', 0, '2024-09-17 04:14:07', 'Jim'),
(28, 'I lost my lab staff', 'it is a mockup of my experiments, see below image, if you seen it, please reach me at class 23', 'clean mockup.png', 1, '2024-09-17 04:15:15', 'Jim'),
(29, 'Who is she, is she a star?', 'this happens in the airport', 'WeChat Image_20221206161248.gif', 0, '2024-09-17 04:16:03', 'Jim'),
(30, 'AI Art Club need 3 new members', 'In AI Art Club, we practice traditional Art design principles and leverage latest AI technology,please reach Amy in lunch hall at 4pm, she will always be there in workdays.', 'cabin.png', 0, '2024-09-17 04:19:00', 'Jim'),
(31, 'Hi, I am Justin', 'I am new to this school, please invite me if you have party or basketball match.', 'basketball.gif', 0, '2024-09-17 04:22:53', 'Justin'),
(32, 'Please see my final work', 'my IB subject is computer HL, my final IA is a school BBS website, though BBS website is very popular have many open source packages, but I decided to work on my own hands without any open sourced packages, I want build a super light BBS website and run the whole system on a normal laptop. I carefully designed the minimal features with minimal code. And the school BBS works great!', '', 0, '2024-09-17 08:46:23', 'Amy');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Lei', 'LEI3377@hotmail.com', '$2y$10$KwKR9MW4y0dAW97Cd2iITeziqxfBDo6kc3YADb0nFNZgBFtspQZvu', '2024-09-15 15:08:03'),
(2, 'Zhgt', 'zhgt@outlook.com', '$2y$10$7em7VG5jZQMIlo6I.1Cu0u98hc0X2PqHioR6/ms7LQTaR2a9GX1LW', '2024-09-15 15:11:21'),
(5, 'Jim', 'jim@outlook.com', '$2y$10$HJkZeX9NI79avIUPIfLUdOC/8C0HNwDxMv5weq3DKiTui2btfQtc.', '2024-09-15 15:13:18'),
(8, 'Amy', 'amy@outlook.com', '$2y$10$Uq6lyC9ALOoSdI1OUhUxju2wHyDQ5mgn6FlMQQgFczerHjd5gP04C', '2024-09-15 15:40:44'),
(9, 'Tom', 'tom@outlook.com', '$2y$10$Z4bwBWXSl1/XRMFskk9Jc.o5zYZCDNCICe6J1xW/mVvXmOgWvnsgi', '2024-09-15 15:59:27'),
(10, 'cc', 'cc@outlook.com', '$2y$10$K0hu6qDgIca4ddwkjyfre.qF3SyYETOPWo7gh0DevvAAb/PaXqW4O', '2024-09-15 16:04:31'),
(12, 'Justin', 'justin@outlook.com', '$2y$10$YWS3NsqSdTE8DbYxUkXM/ucgI68ptCbQiW.O1s7VG9GK7S2d2hDVO', '2024-09-17 04:20:49');

--
-- 转储表的索引
--

--
-- 表的索引 `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
