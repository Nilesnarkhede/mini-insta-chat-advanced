CREATE TABLE users(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 email VARCHAR(100),
 password VARCHAR(255),
 profile VARCHAR(255),
 status ENUM('online','offline') DEFAULT 'offline',
 typing_to INT DEFAULT NULL
);
CREATE TABLE requests(
 id INT AUTO_INCREMENT PRIMARY KEY,
 sender_id INT,
 receiver_id INT,
 status ENUM('pending','accepted','rejected') DEFAULT 'pending'
);
CREATE TABLE messages(
 id INT AUTO_INCREMENT PRIMARY KEY,
 sender_id INT,
 receiver_id INT,
 message TEXT,
 image VARCHAR(255),
 seen TINYINT(1) DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
