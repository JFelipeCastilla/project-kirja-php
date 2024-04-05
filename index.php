<?php
session_start();

// Check if a session variable called "user_id" exists
if (isset($_SESSION["user_id"])) {
    header("Location: ../Sprak/pages/languages.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sprak</title>
    <link rel="stylesheet" href="assets/css/general.css">
    <script defer src="assets/js/fonts.js"></script>
</head>
<body>
    <h1>Sprak</h1>
    <a href="auth/register.php"><span>Registrarse</span></a>
    <a href="auth/login.php"><span>Ingresar</span></a>
</body>
</html>