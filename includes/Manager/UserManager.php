<?php

require_once __DIR__ . '/../Database.php';

class UserManager
{
    private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function registerUser($username, $email, $password)
    {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Bind parameters
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            return "Successfully created new user";
        } else {
            return "Sorry there must have been an issue creating your account";
        }
    }

    public function getUserById($userId)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>