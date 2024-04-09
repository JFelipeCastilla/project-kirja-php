<?php
session_start();
require "../includes/database.php";

// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario
    $book_title = $_POST["book_title"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $publication_year = $_POST["publication_year"];
    $reason_for_reading = $_POST["reason_for_reading"];
    $user_id = $_SESSION["user_id"];

    // Preparamos la consulta SQL para insertar el nuevo libro en la tabla reading_wishlist
    $stmt = $conn->prepare("INSERT INTO reading_wishlist (user_id, book_title, author, genre, publication_year, reason_for_reading) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $book_title, $author, $genre, $publication_year, $reason_for_reading);

    // Ejecutamos la consulta
    if ($stmt->execute()) {
        // Redireccionamos a la página de la lista de deseos de lectura
        header("Location: ../pages/preference.php");
        exit();
    } else {
        // Manejo de error si la consulta falla
        echo "Error al agregar el libro.";
    }
}
?>