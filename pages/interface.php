<?php 
session_start();

// Use database
require "../includes/database.php";

$user = null;

// Check if a session variable called "user_id" exists
if (isset($_SESSION["user_id"])) {
    // Select user information
    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE id = ?");
    // Prepare a SQL statement with an integer parameter
    $stmt->bind_param("i", $_SESSION["user_id"]);
    // Execute the prepared SQL statement
    $stmt->execute();
    // Get the result of the executed query
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}

// if "user_id" no exists so redirect to dashboard
else {
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