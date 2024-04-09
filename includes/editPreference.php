<?php
// Start the session
session_start();
// Include the database connection
require "../includes/database.php";

// If the update form is submitted
if (isset($_POST['update'])) {
    // Get the ID of the reading from the hidden input field
    $id = $_POST['id_reading_wishlist'];
    // Get the values from the submitted form
    $title = $_POST['book_title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $publication_year = $_POST['publication_year'];
    $reason_for_reading = $_POST['reason_for_reading'];

    // Prepare the SQL query to update the entry
    $query = "UPDATE reading_wishlist SET book_title=?, author=?, genre=?, publication_year=?, reason_for_reading=? WHERE id_reading_wishlist=?";
    // Prepare and execute the query with a prepared statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssisi", $title, $author, $genre, $publication_year, $reason_for_reading, $id); // Include the ID in the query here
    $stmt->execute();

    // Redirect to preference.php after the update
    header("Location: ../pages/preference.php");
    exit(); // Exit to prevent further execution
} else {
    // If the update form is not submitted, redirect to preference.php
    header("Location: ../pages/preference.php");
    exit();
}
?>