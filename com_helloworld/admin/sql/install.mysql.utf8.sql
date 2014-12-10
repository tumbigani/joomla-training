DROP TABLE IF EXISTS `#__helloworld`;

CREATE TABLE IF NOT EXISTS `#__helloworld` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `greeting` varchar(25) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;


INSERT INTO `#__helloworld` (`id`, `greeting`, `published`, `checked_out`, `checked_out_time`, `created_by`) VALUES
(1, 'Hello World!', 1, 0, '0000-00-00 00:00:00', 0);