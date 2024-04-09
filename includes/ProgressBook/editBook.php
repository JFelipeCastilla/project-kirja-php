<?php
session_start();
require_once "../../includes/Database.php";
require_once "../../includes/ProgressBook/ProgressManager.php";

// Verificar si la solicitud es mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Depuración: Imprimir los datos recibidos del formulario
    var_dump($_POST);

    // Obtener los datos del formulario de edición
    $id = $_POST['id_reading_progress'];
    $userId = $_SESSION["user_id"];
    $bookTitle = $_POST['book_title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    // Crear una instancia de Database
    $database = new Database("127.0.0.1", "root", "123456", "kirja");

    // Crear una instancia de ProgressManager utilizando la base de datos
    $progressManager = new ProgressManager($database);

    // Actualizar el progreso de lectura en la base de datos
    $success = $progressManager->updateProgress($id, $userId, $bookTitle, $author, $genre, $startDate, $endDate);

    if ($success) {
        // Redirigir al usuario a la página de progreso de lectura o mostrar un mensaje de éxito
        header("Location: ../../pages/ProgressBook.php");
        exit();
    } else {
        // Manejar el error si la actualización falla
        echo "Error al actualizar el progreso de lectura.";
    }
} else {
    // Si la solicitud no es mediante POST, redirigir al usuario a una página de error o mostrar un mensaje de error
    echo "Método no permitido.";
}
?>