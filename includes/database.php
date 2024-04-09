<?php
// Uso de la clase Database
$servername = "127.0.0.1";
$username = "root";
$password = "123456";
$dbname = "kirja";

$database = new Database($servername, $username, $password, $dbname);

class Database
{
    private $conn;

    public function __construct($servername, $username, $password, $dbname)
    {
        // Establecer la conexión
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }

        // Crear tablas al inicializar la conexión
        $this->createTables();
    }

    // Crear tablas
    private function createTables()
    {
        $this->createUsersTable();
        $this->createReadingWishlistTable();
        $this->createReadingProgressTable();
    }

    private function createUsersTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $this->executeQuery($sql, "users");
    }

    private function createReadingWishlistTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS reading_wishlist (
            id_reading_wishlist INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(6) UNSIGNED,
            book_title VARCHAR(255) NOT NULL,
            author VARCHAR(100) NOT NULL,
            genre VARCHAR(100),
            publication_year INT(4),
            reason_for_reading TEXT,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )";

        $this->executeQuery($sql, "reading_wishlist");
    }

    private function createReadingProgressTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS reading_progress (
            id_reading_progress INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(6) UNSIGNED NOT NULL,
            book_title VARCHAR(255) NOT NULL,
            author VARCHAR(100) NOT NULL,
            genre VARCHAR(100),
            start_date DATE,
            end_date DATE,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )";

        $this->executeQuery($sql, "reading_progress");
    }

    // Ejecutar consulta
    private function executeQuery($sql, $tableName)
    {
        if ($this->conn->query($sql) === TRUE) {
            // No imprimes nada aquí para evitar mensajes adicionales
        } else {
            echo "Error creating table '$tableName': " . $this->conn->error . "<br>";
        }
    }

    // Método para obtener la conexión a la base de datos
    public function getConnection()
    {
        return $this->conn;
    }
}
?>