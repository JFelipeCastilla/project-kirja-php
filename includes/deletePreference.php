<?php 
require "../includes/database.php";

if (isset($_POST["id_reading_wishlist"])) {
    $id = $_POST["id_reading_wishlist"];
    $query = "DELETE FROM reading_wishlist WHERE id_reading_wishlist = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    if (!$result) {
        die("Query Failed");
    }
    $_SESSION["message"] = "Book preference removed successfully";
    header("Location: ../pages/preference.php");
    exit();
}
?>