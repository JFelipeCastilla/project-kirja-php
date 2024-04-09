<?php
class ProgressMethods
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function viewReadingProgress($userId)
    {
        $sql = "SELECT * FROM reading_progress WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createReadingProgress($userId, $bookTitle, $author, $genre, $startDate, $endDate)
    {
        $sql = "INSERT INTO reading_progress (user_id, book_title, author, genre, start_date, end_date) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssss", $userId, $bookTitle, $author, $genre, $startDate, $endDate);
        return $stmt->execute();
    }

    public function updateReadingProgress($id, $userId, $bookTitle, $author, $genre, $startDate, $endDate)
    {
        $sql = "UPDATE reading_progress 
                SET user_id=?, book_title=?, author=?, genre=?, start_date=?, end_date=?
                WHERE id_reading_progress=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssssi", $userId, $bookTitle, $author, $genre, $startDate, $endDate, $id);
        return $stmt->execute();
    }

    public function deleteReadingProgress($id)
    {
        $sql = "DELETE FROM reading_progress WHERE id_reading_progress=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Método para obtener los detalles de un progreso de lectura basado en su ID
    public function getReadingProgressDetails($id)
    {
        $sql = "SELECT * FROM reading_progress WHERE id_reading_progress = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>