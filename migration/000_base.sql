CREATE TABLE IF NOT EXISTS `versions`(
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `created` TIMESTAMP DEFAULT current_timestamp,
    PRIMARY KEY (id)
)
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;php