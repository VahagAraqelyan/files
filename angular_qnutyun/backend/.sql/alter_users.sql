  ALTER TABLE  `users` ADD COLUMN `last_update` DATETIME NULL  
  ALTER TABLE  `users` DROP COLUMN `active`; 
  ALTER TABLE  `users` ADD COLUMN `user_status` INT(1) NOT NULL;