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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/general.css">
    <link rel="stylesheet" href="../assets/css/tables.css">
    <script defer src="../assets/js/fonts.js"></script>
    <title>Document</title>
</head>
<body>
    <?php if (!empty($user)): ?>
        <h1>Profile</h1>
        <a href="../auth/logout.php">Logout</a>
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
                <?php 
                    $query = "SELECT * FROM users";
                    $users = mysqli_query($conn, $query);

                    while($row = mysqli_fetch_array($users)) { ?>
                        <tr>
                            <td><?php echo $row["id"] ?></td>
                            <td><?php echo $row["username"] ?></td>
                            <td><?php echo $row["email"] ?></td>
                            <td><?php echo $row["created_at"] ?></td>
                        </tr>
                    <?php } ?>
                ?>
            </tbody>
        </table>
    <?php endif ?>
</body>
</html>