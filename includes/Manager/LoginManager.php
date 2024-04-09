<?php

require_once __DIR__ . '/../Database.php';

class LoginManager
{
    private $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function loginUser($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, email, password FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user["id"];
            return true;
        } else {
            return false;
        }
    }
}
?>