<?php 
session_start();

// Use database
require_once "../includes/database.php";
require_once "../includes/Manager/UserManager.php";

$database = new Database("127.0.0.1", "root", "123456", "kirja");
$conn = $database->getConnection(); // Obtiene la conexión de la base de datos

$userManager = new UserManager($conn);

$user = null;

// Check if a session variable called "user_id" exists
if (isset($_SESSION["user_id"])) {
    // Get user information by ID
    $user = $userManager->getUserById($_SESSION["user_id"]);
}

// If "user_id" does not exist, redirect to the dashboard
else {
    header("Location: ../index.php");
    exit();
}

?>

<?php include("../templates/header.php") ?>
    <?php include("../templates/navbar.php") ?>
    <div class="container-table">
    <?php if (!empty($user)): ?>
        <h1>Profile</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $user["id"] ?></td>
                    <td><?php echo $user["username"] ?></td>
                    <td><?php echo $user["email"] ?></td>
                    <td><?php echo $user["created_at"] ?></td>
                </tr>
            </tbody>
        </table>
    <?php endif ?>
    </div>
<?php include("../templates/footer.php") ?> 