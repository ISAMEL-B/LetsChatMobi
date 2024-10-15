-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 06:47 PM
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
-- Database: `file_sharing`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `file_id` int(11) NOT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `file_path` varchar(100) DEFAULT NULL,
  `sender_office_id` int(11) NOT NULL,
  `receiver_office_id` int(255) NOT NULL,
  `message` text DEFAULT NULL,
  `time_sent` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`file_id`, `file_name`, `file_path`, `sender_office_id`, `receiver_office_id`, `message`, `time_sent`, `is_read`) VALUES
(107, NULL, NULL, 9, 9, 'jfc', '2024-10-08 04:43:15', 1),
(122, NULL, NULL, 8, 9, 'Hello', '2024-10-08 05:51:28', 1),
(125, NULL, NULL, 10, 8, 'Hdhehh', '2024-10-08 06:12:42', 1),
(126, NULL, NULL, 10, 8, 'Hejdjsj', '2024-10-08 06:12:49', 1),
(127, NULL, NULL, 9, 10, 'yesss\n', '2024-10-08 06:14:13', 1),
(128, NULL, NULL, 9, 10, 'HELLO', '2024-10-08 06:18:10', 1),
(129, NULL, NULL, 9, 10, 'HELLO', '2024-10-08 06:18:16', 1),
(130, NULL, NULL, 9, 10, '..MM', '2024-10-08 06:18:30', 1),
(131, NULL, NULL, 9, 10, 'h\no', '2024-10-08 06:20:17', 1),
(133, NULL, NULL, 10, 9, 'man man', '2024-10-08 06:42:47', 1),
(134, NULL, NULL, 10, 9, 'reply', '2024-10-08 06:57:14', 1),
(135, NULL, NULL, 9, 8, 'hello', '2024-10-08 07:03:13', 1),
(136, NULL, NULL, 9, 9, 'self', '2024-10-08 07:03:37', 1),
(137, NULL, NULL, 10, 9, 'Yes', '2024-10-08 07:11:24', 1),
(138, NULL, NULL, 10, 9, 'Man', '2024-10-08 07:11:47', 1),
(139, NULL, NULL, 10, 9, 'Gsush', '2024-10-08 07:11:53', 1),
(140, NULL, NULL, 10, 9, 'Ndnsjs', '2024-10-08 07:11:55', 1),
(141, NULL, NULL, 9, 9, 'meee', '2024-10-08 07:12:19', 1),
(142, NULL, NULL, 9, 9, 'jdhh', '2024-10-08 07:12:47', 1),
(143, NULL, NULL, 9, 10, 'untill', '2024-10-08 07:13:20', 1),
(144, NULL, NULL, 10, 9, 'Plus k', '2024-10-08 07:13:57', 1),
(145, NULL, NULL, 10, 9, 'Really ', '2024-10-08 07:14:20', 1),
(146, NULL, NULL, 9, 10, 'great', '2024-10-08 07:14:29', 1),
(147, NULL, NULL, 9, 9, 'hello', '2024-10-08 07:16:11', 1),
(148, NULL, NULL, 9, 9, 'yes', '2024-10-08 07:19:05', 1),
(149, NULL, NULL, 9, 9, 'hello', '2024-10-08 08:37:14', 1),
(150, NULL, NULL, 9, 9, 'hello', '2024-10-08 08:37:50', 1),
(151, NULL, NULL, 9, 10, 'yest', '2024-10-08 12:32:29', 1),
(152, NULL, NULL, 9, 8, 'hello', '2024-10-08 12:33:02', 1),
(153, NULL, NULL, 12, 13, 'hello', '2024-10-08 12:57:27', 1),
(154, NULL, NULL, 12, 13, 'meu', '2024-10-08 12:57:35', 1),
(157, NULL, NULL, 12, 9, 'jwebk ', '2024-10-08 12:58:16', 1),
(158, NULL, NULL, 12, 9, '9oyucfg', '2024-10-08 12:58:19', 1),
(159, NULL, NULL, 12, 12, 'hdhchch', '2024-10-08 12:58:38', 1),
(160, NULL, NULL, 13, 12, 'how is you', '2024-10-08 12:59:13', 1),
(161, NULL, NULL, 13, 12, 'kueio', '2024-10-08 12:59:19', 1),
(162, NULL, NULL, 13, 12, 'udjk', '2024-10-08 12:59:23', 1),
(163, NULL, NULL, 13, 8, 'mam', '2024-10-08 12:59:36', 1),
(165, NULL, NULL, 13, 12, 'hello', '2024-10-08 17:56:42', 1),
(166, NULL, NULL, 13, 12, 'mowwww', '2024-10-08 17:56:55', 1),
(167, NULL, NULL, 13, 9, 'heloo', '2024-10-08 18:22:09', 1),
(168, NULL, NULL, 13, 9, 'here', '2024-10-08 19:28:43', 1),
(169, NULL, NULL, 13, 10, 'yes tezt', '2024-10-08 19:48:15', 0),
(170, NULL, NULL, 13, 12, 'hello', '2024-10-08 20:27:03', 1),
(171, NULL, NULL, 13, 12, 'heloo..', '2024-10-08 20:32:19', 1),
(172, NULL, NULL, 13, 9, 'hello', '2024-10-08 21:04:00', 1),
(173, NULL, NULL, 9, 9, 'hello', '2024-10-08 23:46:12', 1),
(174, NULL, NULL, 9, 9, 'i am', '2024-10-08 23:46:26', 1),
(175, NULL, NULL, 9, 9, 'when', '2024-10-08 23:46:32', 1),
(176, NULL, NULL, 9, 9, 'called', '2024-10-08 23:46:39', 1),
(177, NULL, NULL, 9, 9, 'Working ', '2024-10-08 23:47:09', 1),
(178, NULL, NULL, 9, 10, 'hello', '2024-10-09 03:42:37', 1),
(179, NULL, NULL, 9, 10, 'realy', '2024-10-09 03:42:51', 1),
(181, NULL, NULL, 8, 10, 'And then', '2024-10-09 04:23:34', 1),
(182, NULL, NULL, 8, 10, 'Hello', '2024-10-09 04:37:06', 1),
(183, NULL, NULL, 8, 9, 'Hello', '2024-10-09 04:38:13', 1),
(184, NULL, NULL, 9, 12, 'And you', '2024-10-09 18:36:02', 1),
(186, NULL, NULL, 9, 8, 'Fjfkf', '2024-10-09 18:41:39', 1),
(187, NULL, NULL, 9, 8, 'Vmxjd', '2024-10-09 18:41:42', 1),
(188, NULL, NULL, 9, 8, 'Guf', '2024-10-09 18:41:54', 1),
(189, NULL, NULL, 9, 8, 'Fufy', '2024-10-09 18:41:58', 1),
(190, NULL, NULL, 9, 8, 'Dhf', '2024-10-09 18:42:01', 1),
(191, NULL, NULL, 9, 8, 'Jvjc', '2024-10-09 18:42:12', 1),
(192, NULL, NULL, 9, 8, 'H', '2024-10-09 19:01:03', 1),
(193, NULL, NULL, 9, 8, 'Fo', '2024-10-09 19:01:18', 1),
(194, NULL, NULL, 9, 8, 'G', '2024-10-09 19:06:16', 1),
(195, NULL, NULL, 9, 8, 'Yu', '2024-10-09 19:07:26', 1),
(196, NULL, NULL, 9, 8, 'Kkk', '2024-10-09 19:07:31', 1),
(197, NULL, NULL, 9, 8, 'Hjg', '2024-10-09 19:09:27', 1),
(198, NULL, NULL, 9, 8, 'Ghf', '2024-10-09 19:09:30', 1),
(199, NULL, NULL, 9, 8, 'Isa', '2024-10-09 19:12:22', 1),
(200, NULL, NULL, 9, 8, 'Dgd', '2024-10-09 19:13:10', 1),
(201, NULL, NULL, 9, 8, 'Hellllooooo', '2024-10-09 19:13:33', 1),
(202, NULL, NULL, 9, 8, 'Fhdh', '2024-10-09 19:13:59', 1),
(203, NULL, NULL, 9, 8, 'Fhdh', '2024-10-09 19:14:01', 1),
(204, NULL, NULL, 9, 8, 'Duru', '2024-10-09 19:14:02', 1),
(205, NULL, NULL, 9, 8, 'Dgd', '2024-10-09 19:14:04', 1),
(206, NULL, NULL, 9, 12, 'Hellooo shere', '2024-10-09 20:50:22', 1),
(207, NULL, NULL, 12, 9, 'what', '2024-10-09 20:51:06', 1),
(208, NULL, NULL, 9, 12, 'Hey', '2024-10-09 22:10:16', 1),
(209, NULL, NULL, 12, 9, 'hello', '2024-10-09 22:11:06', 1),
(210, NULL, NULL, 12, 9, 'me', '2024-10-09 22:11:40', 1),
(211, NULL, NULL, 12, 9, 'hello', '2024-10-09 22:41:39', 1),
(212, NULL, NULL, 12, 9, 'last', '2024-10-09 22:42:02', 1),
(213, NULL, NULL, 9, 12, 'Hell0232', '2024-10-09 23:05:29', 1),
(214, NULL, NULL, 9, 12, 'Time', '2024-10-09 23:09:58', 1),
(215, NULL, NULL, 12, 9, 'codeb is', '2024-10-09 23:11:26', 1),
(216, NULL, NULL, 9, 12, 'Fgdt', '2024-10-09 23:13:14', 1),
(217, NULL, NULL, 9, 12, '222', '2024-10-09 23:13:24', 1),
(218, NULL, NULL, 9, 12, 'Isa', '2024-10-09 23:43:30', 1),
(219, NULL, NULL, 12, 9, 'yes isa', '2024-10-09 23:43:54', 1),
(220, NULL, NULL, 12, 13, 'now', '2024-10-09 23:44:42', 1),
(221, NULL, NULL, 9, 8, 'Man', '2024-10-09 23:54:38', 1),
(222, NULL, NULL, 9, 12, 'Sheriui', '2024-10-09 23:55:00', 1),
(223, NULL, NULL, 12, 9, 'wangi isa', '2024-10-09 23:56:04', 1),
(224, NULL, NULL, 9, 11, 'Hello', '2024-10-09 23:57:23', 1),
(226, NULL, NULL, 9, 9, 'Hello my self', '2024-10-10 02:12:46', 1),
(227, NULL, NULL, 9, 12, 'Yy', '2024-10-10 03:30:16', 1),
(228, NULL, NULL, 9, 12, '<?php\nsession_start();\ninclude \'../../register/config/db.php\';\n\n// Check if user is logged in\nif (!isset($_SESSION[\'user_id\'])) {\n    echo \"Unauthorized access.\";\n    exit();\n}\n\nif ($_SERVER[\'REQUEST_METHOD\'] == \'POST\') {\n    $file_id = intval($_POST[\'file_id\']);\n\n    // Prepare and execute the delete statement\n    $stmt = $conn->prepare(\"DELETE FROM files WHERE file_id = ?\");\n    $stmt->bind_param(\"i\", $file_id);\n    $stmt->execute();\n\n    if ($stmt->affected_rows > 0) {\n        echo \"Message deleted successfully.\";\n    } else {\n        echo \"Failed to delete message.\";\n    }\n\n    $stmt->close();\n    $conn->close();\n} else {\n    echo \"Invalid request.\";\n}\n?>', '2024-10-10 03:31:46', 1),
(231, NULL, NULL, 9, 12, 'Htghg', '2024-10-10 04:29:08', 1),
(232, 'above question.txt', 'uploads/file_670761b55d6290.67983660_above_question.txt', 9, 12, '', '2024-10-10 05:10:13', 1),
(233, 'cad ansers.dotx', 'uploads/file_670762cd7e4a25.98645112_cad_ansers.dotx', 9, 12, '', '2024-10-10 05:14:53', 1),
(234, 'Lecture_notes (12).pdf', 'uploads/file_670762e712e3e8.86387785_Lecture_notes__12_.pdf', 9, 12, 'receive', '2024-10-10 05:15:19', 1),
(235, '', '', 9, 12, 'ghgg', '2024-10-10 05:15:38', 1),
(238, 'above question.txt', 'uploads/file_67076425654c97.33587770_above_question.txt', 9, 12, '', '2024-10-10 05:20:37', 1),
(239, 'above question.txt', 'uploads/file_67076938d48729.56826871_above_question.txt', 9, 12, '', '2024-10-10 05:42:17', 1),
(240, 'above question.txt', 'uploads/file_67076eed863093.53684359_above_question.txt', 9, 10, '', '2024-10-10 06:06:37', 1),
(241, '', '', 9, 10, 'jjhh', '2024-10-10 06:06:46', 1),
(242, '', '', 9, 10, 'bbb', '2024-10-10 06:06:56', 1),
(243, '', '', 9, 10, 'jjjj', '2024-10-10 06:07:11', 1),
(244, '', '', 9, 10, 'jjj', '2024-10-10 06:07:55', 1),
(245, '', '', 9, 10, 'hm', '2024-10-10 06:09:27', 1),
(247, '', '', 9, 10, 'jhjh', '2024-10-10 06:13:19', 1),
(248, '', '', 9, 10, 'plplp0000000000000000', '2024-10-10 06:13:30', 1),
(249, 'above question.txt', 'uploads/file_67077095c7d9d7.34153571_above_question.txt', 9, 10, 'hggh', '2024-10-10 06:13:41', 1),
(250, 'above question.txt', 'uploads/file_670770a2291b15.64830304_above_question.txt', 9, 10, '', '2024-10-10 06:13:54', 1),
(251, 'IMG_20241009_140458_337.jpg', 'uploads/file_670772c6aba155.71607239_IMG_20241009_140458_337.jpg', 9, 10, 'Xvxvxvxvcvxvx', '2024-10-10 06:23:02', 1),
(253, 'above question.txt', 'uploads/file_67077baf171525.86904357_above_question.txt', 9, 10, 'hh', '2024-10-10 07:01:03', 1),
(254, 'above question.txt', 'uploads/file_67077bcc0cdea0.11823248_above_question.txt', 9, 10, '', '2024-10-10 07:01:32', 1),
(255, 'photo sharing.php', 'uploads/file_67077cf47df6d7.61284787_photo_sharing.php', 9, 10, 'yyynn', '2024-10-10 07:06:28', 1),
(256, '', '', 9, 9, 'Vbcbc', '2024-10-10 07:43:21', 1),
(257, '', '', 9, 9, 'Vhgg', '2024-10-10 07:43:26', 1),
(258, '', '', 9, 9, 'Yyhh', '2024-10-10 07:43:58', 1),
(259, '', '', 9, 9, 'bhn', '2024-10-10 07:44:57', 1),
(260, '', '', 9, 9, 'Ghg\nJjfg', '2024-10-10 07:45:43', 1),
(261, '', '', 9, 9, 'Fufgf', '2024-10-10 07:45:48', 1),
(262, '', '', 9, 9, 'hdhch', '2024-10-10 07:46:06', 1),
(263, '', '', 9, 9, 'jdhchch', '2024-10-10 07:46:13', 1),
(264, '', '', 9, 9, '00000008900', '2024-10-10 07:46:21', 1),
(265, 'photo sharing.php', 'uploads/file_670786bee09d94.18735600_photo_sharing.php', 9, 9, '', '2024-10-10 07:48:14', 1),
(266, 'canvas.html', 'uploads/file_670786cf366955.25106280_canvas.html', 9, 9, '', '2024-10-10 07:48:31', 1),
(267, '', '', 9, 9, 'hello', '2024-10-10 07:51:44', 1),
(276, NULL, NULL, 12, 9, 'tete', '2024-10-15 07:47:02', 1),
(277, NULL, NULL, 12, 9, 'sssss', '2024-10-15 07:49:35', 1),
(278, NULL, NULL, 12, 9, 'hdhshs', '2024-10-15 07:50:48', 1),
(279, NULL, NULL, 12, 9, 'hghh', '2024-10-15 07:52:03', 1),
(280, NULL, NULL, 12, 9, 'yyy', '2024-10-15 07:58:44', 1),
(281, NULL, NULL, 12, 9, '12233', '2024-10-15 08:07:09', 1),
(282, NULL, NULL, 12, 9, 'tttttt', '2024-10-15 08:08:39', 1),
(283, NULL, NULL, 12, 9, 'jjjj', '2024-10-15 08:08:47', 1),
(284, NULL, NULL, 12, 9, 'kkkkkkkkkk', '2024-10-15 08:10:13', 1),
(285, NULL, NULL, 12, 9, 'kkkkkkkkkk', '2024-10-15 08:10:17', 1),
(286, NULL, NULL, 12, 9, 'jdj', '2024-10-15 08:20:32', 1),
(287, NULL, NULL, 12, 9, 'ff', '2024-10-15 08:29:43', 1),
(289, NULL, NULL, 12, 12, 'hj', '2024-10-15 08:42:07', 1),
(290, NULL, NULL, 12, 12, 'hh', '2024-10-15 08:51:00', 1),
(291, NULL, NULL, 12, 12, 'jjj', '2024-10-15 08:52:28', 1),
(292, NULL, NULL, 12, 12, 'yryry', '2024-10-15 08:54:47', 1),
(293, NULL, NULL, 10, 8, 'Hello', '2024-10-15 09:30:11', 1),
(295, NULL, NULL, 10, 10, 'Yeah ', '2024-10-15 10:56:32', 1),
(296, NULL, NULL, 12, 10, 'jh', '2024-10-15 11:02:22', 1),
(297, NULL, NULL, 12, 10, 'when', '2024-10-15 11:16:02', 1),
(299, NULL, NULL, 12, 9, 'fghj', '2024-10-15 11:36:58', 1),
(300, NULL, NULL, 12, 9, 'sdstt', '2024-10-15 11:37:04', 1),
(301, NULL, NULL, 12, 9, 'ghjmk', '2024-10-15 11:37:13', 1),
(303, NULL, NULL, 12, 9, 'jjj', '2024-10-15 11:58:14', 1),
(304, 'Screenshot 2024-10-15 101312.png', 'uploads/Screenshot 2024-10-15 101312.png', 12, 9, 'ggd', '2024-10-15 12:05:47', 0),
(305, '', '', 10, 12, '4e5r', '2024-10-15 12:07:42', 1),
(306, '', '', 12, 10, 'good evening', '2024-10-15 12:09:06', 1),
(307, 'Screenshot 2024-10-15 101343.png', 'uploads/Screenshot 2024-10-15 101343.png', 12, 10, 'k', '2024-10-15 12:14:04', 1),
(308, '', '', 17, 8, 'Hey isa', '2024-10-15 12:15:00', 1),
(309, '', '', 17, 12, 'Hey sherie', '2024-10-15 12:16:09', 1),
(310, '', '', 16, 17, 'Hey', '2024-10-15 12:16:39', 1),
(311, '', '', 12, 17, 'yes bro', '2024-10-15 12:17:00', 1),
(312, '', '', 17, 16, 'Yoo bob', '2024-10-15 12:17:28', 1),
(313, 'IMG-20241015-WA0002.jpg', 'uploads/IMG-20241015-WA0002.jpg', 16, 17, 'Yo', '2024-10-15 12:17:56', 1),
(314, '17289946726488461471555299900215.jpg', 'uploads/17289946726488461471555299900215.jpg', 17, 16, 'Sent pic', '2024-10-15 12:18:31', 1),
(315, '', '', 12, 17, 'yes brother', '2024-10-15 12:26:22', 1),
(316, '', '', 16, 17, 'U', '2024-10-15 12:31:34', 1),
(317, '', '', 12, 8, 'yes bro', '2024-10-15 12:32:23', 1),
(318, '', '', 16, 16, 'You bro', '2024-10-15 12:32:45', 1),
(320, '', '', 12, 8, 'jjjj', '2024-10-15 13:14:59', 1),
(321, 'Screenshot 2024-10-15 101343.png', 'uploads/Screenshot 2024-10-15 101343.png', 12, 8, 'regg', '2024-10-15 13:15:12', 1),
(323, '1729000896_01 Crazi kid000.mp3', 'uploads/1729000896_01 Crazi kid000.mp3', 12, 8, '', '2024-10-15 14:01:36', 1),
(324, '1729001535_00 - Forever - Justin BiebeA_022839.mp3', 'uploads/1729001535_00 - Forever - Justin BiebeA_022839.mp3', 12, 8, 'hnh', '2024-10-15 14:12:15', 1),
(326, '00 - Forever - Justin BiebeA_022839.mp3', 'uploads/00 - Forever - Justin BiebeA_022839.mp3', 12, 8, '', '2024-10-15 14:12:38', 1),
(327, '', '', 8, 12, 'Yes please', '2024-10-15 14:25:26', 1),
(328, '1729002544_d3db448c87763b3df2c55d02af3d2cca.mp4', 'uploads/1729002544_d3db448c87763b3df2c55d02af3d2cca.mp4', 8, 12, '', '2024-10-15 14:29:04', 1),
(329, '1729003033_[Mp3jaja.com Music] Shemererwa - Joyce Mugasha.mp3', 'uploads/1729003033_[Mp3jaja.com Music] Shemererwa - Joyce Mugasha.mp3', 12, 8, '', '2024-10-15 14:37:13', 1),
(330, '1729003366_Screenshot 2024-10-15 101343.png', 'uploads/1729003366_Screenshot 2024-10-15 101343.png', 12, 8, '', '2024-10-15 14:42:46', 1),
(331, '1729003941_Screenshot 2024-10-15 101343.png', 'uploads/1729003941_Screenshot 2024-10-15 101343.png', 12, 17, 'uu', '2024-10-15 14:52:21', 1),
(332, '', '', 12, 17, 'yuu', '2024-10-15 14:57:54', 1),
(333, '1729004284_Screenshot 2024-10-15 101343.png', 'uploads/1729004284_Screenshot 2024-10-15 101343.png', 12, 17, '', '2024-10-15 14:58:04', 1),
(334, '1729006562_17290065475801924891087235951745.jpg', 'uploads/1729006562_17290065475801924891087235951745.jpg', 8, 12, '', '2024-10-15 15:36:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id` int(11) NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `attachment` varchar(50) DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mails`
--

INSERT INTO `mails` (`id`, `recipient_email`, `subject`, `message`, `attachment`, `sent_at`) VALUES
(1, 'byaruhangaisamelk@gmail.com', 'MARKS', 'Real', NULL, '2024-10-15 16:42:39'),
(2, 'byaruhangaisamelk@gmail.com', 'Re window', 'Yes', 'uploads/cad ansers.dotx', '2024-10-15 16:43:33');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `office_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone_number` varchar(45) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `reset_code` varchar(50) DEFAULT NULL,
  `code_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`office_id`, `email`, `username`, `password`, `date_created`, `phone_number`, `fname`, `reset_code`, `code_expiry`) VALUES
(8, 'byaruhangaisamelk@gmail.com', 'isak', '$2y$10$qGLMSNg.6We9DEXvRpxQfu1h/sMmbUcYQOfzEcckcIHS6qCHIcZg2', '2024-10-04 10:23:55', '0757003628', 'BYARUHANGA ISAMEL', NULL, NULL),
(9, '2021bse043@std.must.ac.ug', 'NAVIE', '$2y$10$ewrXHE8dEBdcF4OFWCuRheMu21UTtQ34dJyBk21YVSeAdwpXJX.G.', '2024-10-04 12:39:10', '0757094854', 'Isamel Byaruhanga', NULL, NULL),
(10, 'godigitaltech001@gmail.com', 'test', '$2y$10$e5aXOXZcvgKB9fO8boZ71.5U/lEtUpRfgPekqSOhdX5O/TkdQlcya', '2024-10-08 06:02:42', '0773494188', 'Test', NULL, NULL),
(11, 'john@gmail.com', 'john', '$2y$10$J209y3MBG4oxbkjeUoJJM.gULBtpblpTbMo6KiC1UCUicWPW6aWOi', '2024-10-08 12:52:49', '0777777777', 'Aine John', NULL, NULL),
(12, 'she@gmail.com', 'sherie', '$2y$10$xcgPdDhUxX.XGz5gdVdHF.t4fhQbc3vzd6JaFkP3GEkbfYaugZ47S', '2024-10-08 12:54:10', '0788888888', 'Arinda Sherie', NULL, NULL),
(13, 'man@gmail.com', 'man', '$2y$10$Q1IkrJ/urUk5uDcvtzI5MOo3uYmE3oBtQTAIsnh1Sbmogfs3dwHQq', '2024-10-08 12:54:58', '0757000000', 'mm', NULL, NULL),
(14, 'pa@gmail.com', 'papa', '$2y$10$L1FjHgknOChp8Tckzx9tKOtH1.UvDUH4AIzBeXNlokm2kj3kVbFoW', '2024-10-08 12:55:36', '0757003600', 'papa', NULL, NULL),
(15, 'me@u.n', 'me', '$2y$10$HSzIQEXUay5uolZEqnUnWeCzGvp74sx1bsBfEMG39NWks86Clrnl.', '2024-10-08 12:56:21', '0778899001', '12', NULL, NULL),
(16, 'boazmucunguzi7@gmail.com', 'Bob', '$2y$10$iN.cwTFjJCEss10B1sEBnue0itOagqA/e61YSNcSm52djs3/qcI.m', '2024-10-15 12:14:14', '773345528', 'Mucunguzi ', NULL, NULL),
(17, 'mujunidandas007@gmail.com', 'Mujuni', '$2y$10$/MAvZSJPWSVB8JulPOusNeAEcrPDOs2NswYBBywEMUnJD5/A4bRHG', '2024-10-15 12:14:18', '+25677898282', 'Mujuni', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`file_id`),
  ADD KEY `sender_office_id` (`sender_office_id`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`office_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`sender_office_id`) REFERENCES `offices` (`office_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
