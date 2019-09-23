/*Users Table SQL*/
CREATE TABLE `net_worth`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` VARCHAR(222) NOT NULL , `name` VARCHAR(222) NOT NULL , `email` VARCHAR(222) NOT NULL , `password` VARCHAR(222) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

/*Pending Users Table SQL*/
CREATE TABLE `net_worth`.`pending_user` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` VARCHAR(222) NOT NULL , `name` VARCHAR(222) NOT NULL , `email` VARCHAR(222) NOT NULL , `password` VARCHAR(222) NOT NULL , `verification_id` VARCHAR(222) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;