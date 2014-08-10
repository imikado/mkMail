




CREATE TABLE IF NOT EXISTS `blackwords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB ;



CREATE TABLE IF NOT EXISTS `box` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) DEFAULT NULL,
  `ordered` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `columns` varchar(60) DEFAULT NULL,
  `keywords` varchar(45) DEFAULT NULL,
  `width` varchar(45) DEFAULT NULL,
  `height` varchar(45) DEFAULT NULL,
  `tags` varchar(45) DEFAULT NULL,
  `title` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `picture` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 ;



CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mails_id` int(11) DEFAULT NULL,
  `path` varchar(160) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB ;



CREATE TABLE IF NOT EXISTS `keywords` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB ;



CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL,
  `url` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `mails_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB ;



CREATE TABLE IF NOT EXISTS `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(200) DEFAULT NULL,
  `body` text,
  `messageId` varchar(250) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  `from_id` int(11) NOT NULL,
  `hasFiles` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS `mails_keywords` (
  `mails_id` int(11) NOT NULL,
  `keywords_id` int(11) NOT NULL,
  PRIMARY KEY (`mails_id`,`keywords_id`)
) ENGINE=InnoDB ;



CREATE TABLE IF NOT EXISTS `mails_tags` (
  `mails_id` int(11) NOT NULL DEFAULT '0',
  `tags_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mails_id`,`tags_id`)
) ENGINE=InnoDB ;



CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB ;




