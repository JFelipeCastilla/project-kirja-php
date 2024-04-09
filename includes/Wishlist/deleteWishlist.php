<?php
session_start();
require_once "../../includes/Database.php";
require_once "../WishList/WishlistManager.php";

// Verificar si la solicitud es mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del elemento de wishlist a eliminar
    $id = $_POST['id'];

    // Crear una instancia de Database
    $database = new Database("127.0.0.1", "root", "123456", "kirja");

    // Crear una instancia de WishlistManager utilizando la base de datos
    $wishlistManager = new WishlistManager($database);

    // Eliminar un elemento de la wishlist de la base de datos
    $success = $wishlistManager->deleteWishlistItem($id);

    if ($success) {
        // Redirigir al usuario a la página de wishlist o mostrar un mensaje de éxito
        header("Location: ../../pages/WishList.php");
        exit();
    } else {
        // Manejar el error si la eliminación falla
        echo "Error al eliminar el elemento de la wishlist.";
    }
} else {
    // Si la solicitud no es mediante POST, redirigir al usuario a una página de error o mostrar un mensaje de error
    echo "Método no permitido.";
}
?>