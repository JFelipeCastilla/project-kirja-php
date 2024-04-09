<?php
session_start();
require_once "../../includes/Database.php";
require_once "./WishlistManager.php";

// Verificar si la solicitud es mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario de creación de wishlist
    $userId = $_SESSION["user_id"];
    $bookTitle = $_POST['book_title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $publicationYear = $_POST['publication_year'];
    $reasonForReading = $_POST['reason_for_reading'];

    // Crear una instancia de Database
    $database = new Database("127.0.0.1", "root", "123456", "kirja");

    // Crear una instancia de WishlistManager utilizando la base de datos
    $wishlistManager = new WishlistManager($database);

    // Agregar un elemento a la wishlist en la base de datos
    $success = $wishlistManager->addWishlistItem($userId, $bookTitle, $author, $genre, $publicationYear, $reasonForReading);

    if ($success) {
        // Redirigir al usuario a la página de wishlist o mostrar un mensaje de éxito
        header("Location: ../../pages/WishList.php");
        exit();
    } else {
        // Manejar el error si la adición falla
        echo "Error al agregar el elemento a la wishlist.";
    }
} else {
    // Si la solicitud no es mediante POST, redirigir al usuario a una página de error o mostrar un mensaje de error
    echo "Método no permitido.";
}
?>