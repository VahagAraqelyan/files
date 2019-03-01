ALTER TABLE `users` ADD `state` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `users` ADD `account_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `users` CHANGE `country` `country_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `users` CHANGE `state` `state_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
