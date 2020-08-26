CREATE TABLE `users`(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL UNIQUE,
    `pass` VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

    INSERT INTO `users` (username,pass)
    VALUES ('admin', '$2y$10$ohyLA1D8L32rsSRjjEx.te/voYa20ptlL3qkfJ.mdC/E.VYc3Dao.');