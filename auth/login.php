<?php
session_start();

// Check if a session variable called "user_id" exists
if (isset($_SESSION["user_id"])) {
    header("Location: ../pages/interface.php");
}

// Use database
require "../includes/database.php";

// Check if the email and password have been sent using a form
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    // Get the email and password sent by the form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Select user information
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email=?");
    // Prepare a SQL statement with an integer parameter
    $stmt->bind_param("s", $email);
    // Execute the prepared SQL statement
    $stmt->execute();
    // Get the result of the executed query
    $result = $stmt->get_result();
    // Retrieve the next row of results as an associative array
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION["user_id"] = $user["id"];
        header("Location: ../pages/interface.php");
        exit;
    } else {
        $message = "Invalid credentials";
    }
}
?>

<?php include("../templates/header.php") ?>
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
<?php include("../templates/footer.php") ?>