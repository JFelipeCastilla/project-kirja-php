<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: ../pages/languages.php");
}

require "../includes/database.php";

if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION["user_id"] = $user["id"];
        header("Location: ../pages/languages.php");
        exit;
    } else {
        $message = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/general.css">
    <link rel="stylesheet" href="../assets/css/inputs.css">
    <title>Register</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <?php if (!empty($message)) : ?>
            <p><?= $message ?></p>
        <?php endif ?>

        <form class="form-container" action="login.php" method="POST">
            <input class="input" name="email" type="text" placeholder="Email">
            <input class="input" name="password" type="password" placeholder="Password">
            <button class="button" type="submit">Login</button>
        </form>
    </div>
</body>
</html>
