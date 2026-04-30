CREATE TABLE IF NOT EXISTS `mentor_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mentor_user_id` int(11) NOT NULL,
  `student_user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `mentor_user_id` (`mentor_user_id`),
  KEY `student_user_id` (`student_user_id`),
  CONSTRAINT `fk_mc_mentor` FOREIGN KEY (`mentor_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mc_student` FOREIGN KEY (`student_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
