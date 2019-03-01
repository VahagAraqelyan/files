DROP TABLE `customers`; 
ALTER TABLE `users` ADD COLUMN `customer_id` VARCHAR(255) NULL AFTER `account_name`; 