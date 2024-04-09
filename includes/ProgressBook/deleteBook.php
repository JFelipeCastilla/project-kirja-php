<?php
session_start();
require_once "../../includes/Database.php";
require_once "../../includes/ProgressBook/ProgressManager.php";

// Verificar si la solicitud es mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del progreso de lectura a eliminar
    $id = $_POST['id'];

    // Crear una instancia de Database
    $database = new Database("127.0.0.1", "root", "123456", "kirja");

    // Crear una instancia de ProgressManager utilizando la base de datos
    $progressManager = new ProgressManager($database);

    // Eliminar el progreso de lectura de la base de datos
    $success = $progressManager->deleteProgress($id);

    if ($success) {
        // Redirigir al usuario a la página de progreso de lectura o mostrar un mensaje de éxito
        header("Location: ../../pages/ProgressBook.php");
        exit();
    } else {
        // Manejar el error si la eliminación falla
        echo "Error al eliminar el progreso de lectura.";
    }
} else {
    // Si la solicitud no es mediante POST, redirigir al usuario a una página de error o mostrar un mensaje de error
    echo "Método no permitido.";
}
?>