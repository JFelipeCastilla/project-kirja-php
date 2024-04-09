<?php 
session_start();
require "../includes/database.php";

if (isset($_POST["id_reading_progress"])) {
    $id = $_POST["id_reading_progress"];
    $query = "DELETE FROM reading_progress WHERE id_reading_progress = ?"; 
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if (!$result) {
        die("Query Failed");
    }
    $_SESSION["message"] = "Book progress removed successfully";
    header("Location: ../pages/readingbook.php");
    exit();
}
?>
