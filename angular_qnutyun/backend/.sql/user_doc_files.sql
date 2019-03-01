CREATE TABLE `user_doc_files` (
  `id` bigint(40) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(40) NOT NULL COMMENT 'user_id',
  `doc_type_id` int(11) NOT NULL,
  `doc_type_name` varchar(100) NOT NULL,
  `show_doc_name` varchar(255) NOT NULL,
  `doc_file` varchar(255) NOT NULL,
  `reviewed_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0=Not Reviewed yet, 1=Reviewed by admin.',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive',
  `add_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

