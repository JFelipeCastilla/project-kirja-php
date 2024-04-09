<?php
session_start();
require "../includes/database.php";

// Verificamos si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibimos los datos del formulario
    $book_title = $_POST["book_title"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $user_id = $_SESSION["user_id"];

    // Preparamos la consulta SQL para insertar el nuevo progreso de lectura en la tabla reading_progress
    $stmt = $conn->prepare("INSERT INTO reading_progress (user_id, book_title, author, genre, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $book_title, $author, $genre, $start_date, $end_date);

    // Ejecutamos la consulta
    if ($stmt->execute()) {
        // Redireccionamos a la página de progreso de lectura
        header("Location: ../pages/readingbook.php");
        exit();
    } else {
        // Manejo de error si la consulta falla
        echo "Error al agregar el progreso de lectura.";
    }
}
?>