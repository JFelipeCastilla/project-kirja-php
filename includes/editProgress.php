<?php
// Start the session
session_start();
// Include the database connection
require "../includes/database.php";

// If the update form is submitted
if (isset($_POST['update'])) {
    // Get the ID of the reading from the hidden input field
    $id = $_POST['id_reading_progress']; // Changed to match the correct ID field
    // Get the values from the submitted form
    $title = $_POST['book_title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $start_date = $_POST['start_date']; // Added to get start date
    $end_date = $_POST['end_date']; // Added to get end date

    // Prepare the SQL query to update the entry
    $query = "UPDATE reading_progress SET book_title=?, author=?, genre=?, start_date=?, end_date=? WHERE id_reading_progress=?";
    // Prepare and execute the query with a prepared statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $title, $author, $genre, $start_date, $end_date, $id); // Include the ID in the query here
    $stmt->execute();

    // Redirect to reading_progress.php after the update
    header("Location: ../pages/readingbook.php");
    exit(); // Exit to prevent further execution
} else {
    // If the update form is not submitted, redirect to reading_progress.php
    header("Location: ../pages/readingbook.php");
    exit();
}
?>
