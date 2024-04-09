<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "kirja";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create a users table
$user = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// SQL query to create a reading_wishlist table
$wishlist = "CREATE TABLE IF NOT EXISTS reading_wishlist (
    id_reading_wishlist INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED,
    book_title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    genre VARCHAR(100),
    publication_year INT(4),
    reason_for_reading TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

// SQL query to create a reading_progress table
$reading = "CREATE TABLE IF NOT EXISTS reading_progress (
    id_reading_progress INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    book_title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    genre VARCHAR(100),
    start_date DATE,
    end_date DATE,
    id_reading_wishlist INT(6) UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (id_reading_wishlist) REFERENCES reading_wishlist(id_reading_wishlist)
)";

// Execute queries
$conn->query($user);
$conn->query($wishlist);
$conn->query($reading);
?>