
`address_book` CHANGE `contact_id` `contact_id` VARCHAR(255) NOT NULL;

ALTER TABLE `prod_domestic_fee` ADD COLUMN `date` DATETIME NULL AFTER `domestic_pattern`;