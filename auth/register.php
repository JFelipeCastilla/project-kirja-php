<?php

session_start();

// Check if a session variable called "user_id" exists
if (isset($_SESSION["user_id"])) {
    header("Location: ../pages/interface.php");
}

// Use database
require "../includes/database.php";

$message = "";

// Insert data into the database if applicable
if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Hash the password
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    
    // Bind parameters
    $stmt->bind_param("sss", $_POST["username"], $_POST["email"], $password);

    if ($stmt->execute()) {
        $message = "Successfully created new user";
    } else {
        $message = "Sorry there must have been an issue creating your account";
    }
}
?>

<?php include("../templates/header.php") ?>
    <?php if(!empty($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <div class="container">
        <h1>Register</h1>
        <form class="form-container" action="register.php" method="POST">
            <input class="input" name="username" type="text" placeholder="Username">
            <input class="input" name="email" type="text" placeholder="Email">
            <input class="input" name="password" type="password" placeholder="Password">
            <button class="button" type="submit">Register</button>
        </form>
    </div>
<?php include("../templates/footer.php") ?>