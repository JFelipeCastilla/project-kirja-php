<?php 
session_start();
require "../includes/database.php";

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
else {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (!empty($user)): ?>
        <h1>Languagues</h1>
        <br>Welcome. <?= $user["username"] ?></br>
        <br>You are Successfully logged In</br>
        <a href="../auth/logout.php">Logout</a>
    <?php endif ?>
</body>
</html>