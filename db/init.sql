CREATE TABLE `novel_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `novel_name` varchar(255) DEFAULT NULL,
  `novel_title` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3767 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `novel_list` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
