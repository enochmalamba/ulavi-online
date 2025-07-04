-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 09:53 PM
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
-- Database: `ulavi_community`
--
CREATE DATABASE IF NOT EXISTS `ulavi_community` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ulavi_community`;

-- --------------------------------------------------------

--
-- Table structure for table `claps`
--

CREATE TABLE `claps` (
  `clap_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(18, 31, 27, 'For uploading songs and movies, you can do it your self when you register as a content creator', '2025-05-12 05:34:10', '2025-05-12 05:34:10'),
(19, 33, 25, 'jjjj', '2025-05-18 19:28:56', '2025-05-18 19:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `community_people`
--

CREATE TABLE `community_people` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `community_people`
--

INSERT INTO `community_people` (`user_id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(25, 'Enoch Malamba', 'enochmalamba@gmail.com', '$2y$10$TdnH/z9LXElw/.uHmHsYXeGmfgcuDwqp1mOgbE6Jd999iyVW6RWPK', '2025-05-10 06:25:13', '2025-05-10 06:25:13'),
(26, 'Xenon Malamba', 'xenonmalamba@gmail.com', '$2y$10$OEdVahka8q0zGt5ggzGukOXjtLZ.amX3Rdhz2NhARHgTLtEFeyIma', '2025-05-10 09:34:27', '2025-05-10 09:34:27'),
(27, 'SevenOmore', 'sevenmajuta@gmail.com', '$2y$10$15dZ/VbPxZdp0tHLPvmmmeJqSCVOI5f/KPrl5GpOlRVTXHee/Qkt6', '2025-05-12 03:31:53', '2025-05-12 03:31:53'),
(28, 'Footprint Malawi', 'footprintmw@protonmail.com', '$2y$10$tMyIHbH2MWEzAO8J14TC5u2upct5PjFSXYtMLMN6lArmJsn/8bfiO', '2025-05-12 05:10:45', '2025-05-12 05:10:45'),
(29, 'Katchana', 'katchana@gmail.com', '$2y$10$TH2TZssZaJA6fJGqD/QYd.pbfVz4PSgkeFjdLVVdHGi0zfFGX5Wei', '2025-05-12 05:22:05', '2025-05-12 05:22:05'),
(30, 'Tammy Mbendera', 'tammymbendera@gmail.com', '$2y$10$cgqZOXKLZ.U1nSFbhcJuLOX5k/u0F7OwequvXcZwNYjSl1hvqak7G', '2025-05-15 05:31:15', '2025-05-15 05:31:15');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `media_url` varchar(255) DEFAULT NULL,
  `category` enum('Project Updates','Events','Discussions','Artist Spotlights','Arts','Community Development') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `title`, `content`, `media_url`, `category`, `created_at`, `updated_at`) VALUES
(27, 26, 'Wassup people', 'I just want to try creating a post so that i can work with it in making this website responsive, nah\' mean\r\n', 'uploads/post-images/681f20f165b98Whisk_8dccfabc26.jpg', 'Arts', '2025-05-10 09:48:33', '2025-05-10 09:48:33'),
(28, 26, 'Hello World', 'Yea so like i was saying i am creating these posts so that i can have something to work but am really going to delete them after am done doing what doing coz i dont want to populate the database with junk by the time you get here. i want you to find it clean, nah\' mean?\r\n', 'uploads/post-images/681f234a5367110.png', 'Arts', '2025-05-10 09:58:34', '2025-05-10 09:58:34'),
(29, 28, 'Artist Spotlight: Elena Gonzalez', 'This month\'s spotlight features Elena Gonzalez, a mixed-media artist whose work explores themes of cultural identity and environmental awareness. Elena has been a Ulavi volunteer for three years and recently led our successful recycled art workshop series.\r\n\r\n\"Art is my way of connecting communities and starting conversations about the issues that matter most to us,\" says Elena. Her upcoming exhibition \"Threads of Connection\" opens next month at the Downtown Gallery.', 'uploads/post-images/68218536c92536b70bf48-e53d-4bbe-b632-ca465743cbf5.png', 'Arts', '2025-05-12 05:20:54', '2025-05-12 05:20:54'),
(30, 29, 'How Can We Make Art More Accessible in Our Community?', 'I\'ve been thinking about barriers that prevent some community members from participating in local arts programs. Cost, transportation, and awareness seem to be the biggest challenges I\'ve noticed.\r\n\r\nWhat ideas do you have for making art more accessible to everyone in our neighborhood, especially seniors and people with disabilities? Have you seen successful approaches in other communities?', 'uploads/post-images/6821864740749Up next.png', 'Arts', '2025-05-12 05:25:27', '2025-05-12 05:25:27'),
(31, 27, 'Introducing urbanlinksmalawi.com!!', 'Am excited to tell you that through ULAVi, we have realesed a platform where music artists and film makers can sale their music and movies or make them availble for free for everyone to see. The making of this site took us a long time but it was worthy the wait. \r\nTikukhulupilira kuti kudzera mu website yathuyi ndekuti miyoyo ya anthu a zama luso itukuka ndipo ma creative akwanitsa kupeza phindu lochuluka kudzera mu luso lawo. \r\nVisit urbanlinksmalawi.com today and create your accounts now for free!!', 'uploads/post-images/682187903bb7curbanlinksmalawi.jpg', 'Arts', '2025-05-12 05:30:56', '2025-05-12 05:30:56'),
(32, 25, 'Wasssuppp!!!', 'ok so its called CAB (careers and jobs). people can find labour and find jobs plus also find scholarships and other related carrer things. people will also do buisness through the market place where people can post things for sell and open shop where they can display their services etc. it has to have three sections, home, careers, and market. create me the document', 'uploads/post-images/6822e81acf785image_fx (5).jpg', 'Arts', '2025-05-13 06:35:06', '2025-05-13 06:35:06'),
(33, 25, 'Yr.2099 Lives', 'hsddhd', 'uploads/post-images/682a34d2071e6499008574_660081883599958_3858305805199028482_n.jpg', 'Arts', '2025-05-18 19:28:18', '2025-05-18 19:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_background`
--

CREATE TABLE `user_background` (
  `background_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `talents` text DEFAULT NULL,
  `school` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_contact_info`
--

CREATE TABLE `user_contact_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `website` varchar(255) NOT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `x_twitter` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_role` enum('Public User','Community Member','Moderator','Admin') NOT NULL DEFAULT 'Public User',
  `user_title` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `user_location` varchar(100) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`info_id`, `user_id`, `user_role`, `user_title`, `dob`, `gender`, `user_location`, `profile_photo`, `bio`, `created_at`, `updated_at`) VALUES
(11, 25, 'Public User', 'Web Developer', '2003-11-05', 'male', 'Lilongwe', 'uploads/profiles/681ef204a7296xenonmalamba.jpg', 'Passionate backend developer skilled in PHP, MySQL, and secure coding. I specialize in user authentication, dynamic content management, and troubleshooting. Currently expanding into Node.js and full-stack development. I love creating efficient, secure applications and exploring remote work opportunities to connect with like-minded developers.', '2025-05-10 06:25:39', '2025-05-10 06:28:20'),
(12, 26, 'Public User', 'Artist', '2003-11-05', 'male', 'Lilongwe, Malawi', 'uploads/profiles/681f1e3ecd92f43566964-9998-11e7-9ae9-0242ac110002-yingchou-han-241463.jpg', 'Hi there! I am an artist who loves to express stories and feeling through paintings and drawings. I am looking forwad to working with anyone or teach anyone how to do what i do as long as they are intrested.', '2025-05-10 09:34:51', '2025-05-10 09:37:02'),
(13, 27, 'Public User', 'Artist &amp; Producer', '2000-05-05', 'male', 'Lilongwe', 'uploads/profiles/68216c70a4412sevenomore.jpg', 'Hey there,     Lorem ipsum dolor sit amet consectetur adipisicing elit. Est velit nostrum doloribus laborum at quo, voluptatibus ullam vitae possimus eveniet beatae autem itaque nisi ex deleniti rerum, sint omnis blanditiis.', '2025-05-12 03:32:11', '2025-05-12 03:35:12'),
(14, 28, 'Public User', 'Record Label', '2000-05-05', 'prefer_not_to_say', 'Blantyre', 'uploads/profiles/6821846ed18afIMG-20211120-WA0022.jpg', 'We are a Distribution company based in Lilongwe working with different Creatives from different industries with our main focus on art.', '2025-05-12 05:11:15', '2025-05-12 05:17:35'),
(15, 29, 'Public User', 'Drummer &amp; Public Relations Manager', '0005-05-05', 'male', 'Mulanje', 'uploads/profiles/6821861276ba5Screenshot (8).png', 'Hello, its Katchana here! Plays drums, manages relations for anyone, low-key-perv. If you need someone to talk to am always here.', '2025-05-12 05:22:20', '2025-05-12 05:24:34'),
(16, 30, 'Public User', 'Artist', '2000-05-05', 'female', 'Lilongwe', 'uploads/profiles/68257cad452a6Open Peeps - Bust.png', 'Y?, this is my bio am just creating this one coz I have to fill it&#039;s a required field or else i wasn&#039;t going to log in', '2025-05-15 05:31:41', '2025-05-15 05:33:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `claps`
--
ALTER TABLE `claps`
  ADD PRIMARY KEY (`clap_id`),
  ADD UNIQUE KEY `unique_post_user_clap` (`user_id`,`post_id`),
  ADD UNIQUE KEY `unique_comment_user_clap` (`user_id`,`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `community_people`
--
ALTER TABLE `community_people`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `unique_post_user_like` (`user_id`,`post_id`),
  ADD UNIQUE KEY `unique_comment_user_like` (`user_id`,`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_posts_category` (`category`);

--
-- Indexes for table `user_background`
--
ALTER TABLE `user_background`
  ADD PRIMARY KEY (`background_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_contact_info`
--
ALTER TABLE `user_contact_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`info_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `claps`
--
ALTER TABLE `claps`
  MODIFY `clap_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `community_people`
--
ALTER TABLE `community_people`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_background`
--
ALTER TABLE `user_background`
  MODIFY `background_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_contact_info`
--
ALTER TABLE `user_contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `claps`
--
ALTER TABLE `claps`
  ADD CONSTRAINT `claps_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `community_people` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `claps_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `claps_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `community_people` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `community_people` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `community_people` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_background`
--
ALTER TABLE `user_background`
  ADD CONSTRAINT `user_background_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `community_people` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_contact_info`
--
ALTER TABLE `user_contact_info`
  ADD CONSTRAINT `user_contact_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `community_people` (`user_id`);

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `community_people` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
