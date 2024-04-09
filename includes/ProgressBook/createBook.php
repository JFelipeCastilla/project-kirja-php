<?php
session_start();
require_once "../Database.php";
require_once "../ProgressBook/ProgressManager.php";

// Verificar si los datos del formulario se enviaron mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear una nueva instancia de Database
    $database = new Database("127.0.0.1", "root", "123456", "kirja");

    // Crear una instancia de ProgressManager utilizando la base de datos
    $progressManager = new ProgressManager($database);

    // Obtener los datos del formulario
    $userId = $_SESSION["user_id"];
    $bookTitle = $_POST["book_title"];
    $author = $_POST["author"];
    $genre = $_POST["genre"];
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

    // Agregar el progreso del libro
    $progressManager->addProgress($userId, $bookTitle, $author, $genre, $startDate, $endDate);

    // Redirigir al usuario a alguna página después de agregar el libro
    header("Location: ../../pages/ProgressBook.php");
    exit();
} else {
    // Si los datos del formulario no se enviaron mediante el método POST, redirigir al usuario a alguna página de error
    header("Location: error_page.php");
    exit();
}
?>