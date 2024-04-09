<?php

session_start();

// Check if a session variable called "user_id" exists
if (isset($_SESSION["user_id"])) {
    header("Location: ../pages/interface.php");
}

// Use database
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Manager/LoginManager.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $database = new Database("localhost", "root", "123456", "kirja");
    $conn = $database->getConnection();
    $loginManager = new LoginManager($conn);

    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        if ($loginManager->loginUser($_POST["email"], $_POST["password"])) {
            header("Location: ../pages/interface.php");
            exit;
        } else {
            $message = "Invalid credentials";
        }
    } else {
        $message = "Please fill all the fields";
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