CREATE TABLE `tasks`(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `text` TEXT NOT NULL,
    `completed` BOOLEAN DEFAULT FALSE,
    `edited` BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (id)
)
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;