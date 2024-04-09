<?php

session_start();

// Check if a session variable called "user_id" exists
if (isset($_SESSION["user_id"])) {
    header("Location: ../pages/interface.php");
}

// Use database
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Manager/UserManager.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $database = new Database("localhost", "root", "123456", "kirja");
    $conn = $database->getConnection();
    $userManager = new UserManager($conn);

    if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
        $message = $userManager->registerUser($_POST["username"], $_POST["email"], $_POST["password"]);
    } else {
        $message = "Please fill all the fields";
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