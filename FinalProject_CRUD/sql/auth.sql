CREATE TABLE users(
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    `password` VARCHAR(255),
    `email` VARCHAR(255),
    image_name VARCHAR(255),
    image_path VARCHAR(255)
)
ENGINE = InnoDB default charset = utf8mb4;

CREATE TABLE messages(
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    uid INT NOT NULL,
    `message_text` VARCHAR(255),
    created varchar(100),
    modified varchar(100),
    deleted varchar(100),
    FOREIGN KEY (uid) REFERENCES users(user_id) ON DELETE CASCADE
)
    ENGINE = InnoDB default charset = utf8mb4;