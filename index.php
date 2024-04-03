<?php 
session_start();
require "includes/database.php";

$user = null;

if (isset($_SESSION["user_id"])) {
    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprak</title>
    <link rel="stylesheet" href="assets/css/general.css">
</head>
<body>
    <h1>Sprak</h1>
    <?php if(!empty($user)): ?>
        <br>Welcome. <?= $user["username"] ?>
        <br>You are Successfully Logged In
        <a href="auth/logout.php">Logout</a>
    <?php else: ?>
        <a href="auth/register.php"><span>Registrarse</span></a>
        <a href="auth/login.php"><span>Ingresar</span></a>
    <?php endif; ?>
</body>
</html>