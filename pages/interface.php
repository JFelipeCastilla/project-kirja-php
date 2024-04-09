<?php 

session_start();

// Use database
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Manager/UserManager.php';
require_once __DIR__ . '/../includes/getBookDetails.php';
require_once __DIR__ . '/../includes/Authentication/AuthenticationManager.php';

$user = null;

// Check if the user is authenticated
if (AuthenticationManager::isAuthenticated()) {
    $database = new Database("localhost", "root", "123456", "kirja");
    $conn = $database->getConnection();
    $userManager = new UserManager($conn);

    $user = $userManager->getUserById($_SESSION["user_id"]);

    if (!$user) {
        // If user doesn't exist, redirect to index
        header("Location: ../index.php");
        exit();
    }
} else {
    // If user is not authenticated, redirect to index
    header("Location: ../index.php");
    exit();
}

?>

<?php include("../templates/header.php") ?>
    <?php include("../templates/navbar.php") ?>
    <div class="inside-container">
        <?php if (!empty($user)): ?>
            <h2>Welcome, <?= $user["username"] ?></h2>
        <?php endif ?>
    </div>
    <div class="container">
        <div class="container-flex">
            <div class="container-icon">        
                <a href="../pages/readingbook.php">
                    <img src="../assets/img/book.png" alt="">
                </a>
            </div>
            <div class="container-icon">
                <a href="../pages/preference.php">
                    <img src="../assets/img/preference.png" alt="">
                </a>
            </div>
            <div class="container-icon">
                <a href="../pages/profile.php">
                    <img src="../assets/img/profile.png" alt="">
                </a>
            </div>
        </div>
    </div>
<?php include("../templates/footer.php") ?>