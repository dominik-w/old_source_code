# database

# users
DROP TABLE IF EXISTS `om_users`;

CREATE TABLE `om_users`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(100)  NOT NULL,
	`login` VARCHAR(32),
	`password` VARCHAR(32)  NOT NULL,
	`mail_hash` VARCHAR(32)  NOT NULL,
	`remember_hash` VARCHAR(32),
	`is_active` TINYINT default 0,
    `is_admin` TINYINT default 0,
	`is_deleted` TINYINT default 0,
	`avatar_path` VARCHAR(255),
	`avatar_ext` VARCHAR(10),
	`avatar_id` INTEGER,
	`last_ip` VARCHAR(15),
	`last_login_at` DATETIME,
	`last_activity_at` DATETIME,
	# `in_newsletter` TINYINT default 0,
	# `last_login_data` VARCHAR(250),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `om_users_I_1`(`email`),
	KEY `om_users_I_2`(`login`)
)Type=MyISAM;

# user profiles
DROP TABLE IF EXISTS `om_user_profiles`;

CREATE TABLE `om_user_profiles`
(
	`user_id` INTEGER  NOT NULL,
	`firstname` VARCHAR(50),
	`lastname` VARCHAR(50),
	`birthdate` DATE,
	`gender` VARCHAR(1),
	`street` VARCHAR(64),
	`local_number` VARCHAR(16),
	`zip` VARCHAR(10),
	`city` VARCHAR(64),
	`land` VARCHAR(64),
	`country` VARCHAR(32),
	`phone` VARCHAR(32),
	`website` VARCHAR(150),
	`about_user` TEXT,
    # `timezone` VARCHAR(64),
	# `is_special` TINYINT default 0,
	# `notify_me_about_pm` TINYINT default 1,
	`updated_at` DATETIME,
	PRIMARY KEY (`user_id`),
	CONSTRAINT `om_user_profiles_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `om_users` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;


# contact
DROP TABLE IF EXISTS `om_contact_messages`;

CREATE TABLE `om_contact_messages`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_name` VARCHAR(200),
	`user_email` VARCHAR(100)  NOT NULL,
	`message` TEXT  NOT NULL,
	`is_read` TINYINT default 0,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	KEY `om_contact_messages_I_1`(`user_email`)
)Type=MyISAM;

