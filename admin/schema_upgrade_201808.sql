CREATE TABLE `quote_tweet` (
  `quote_id` tinyint(3) unsigned NOT NULL,
  `tweet_url` text NOT NULL,
  CONSTRAINT `quote_tweet_fk1` FOREIGN KEY (`quote_id`) REFERENCES `quote` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `quote_tweet` VALUES (18, 'https://twitter.com/hpdailyrant/status/1029016932949753856');