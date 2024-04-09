<?php
class WishlistMethods
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function viewReadingWishlist($userId)
    {
        $sql = "SELECT * FROM reading_wishlist WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createReadingWishlist($userId, $bookTitle, $author, $genre, $publicationYear, $reasonForReading)
    {
        $sql = "INSERT INTO reading_wishlist (user_id, book_title, author, genre, publication_year, reason_for_reading) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssis", $userId, $bookTitle, $author, $genre, $publicationYear, $reasonForReading);
        return $stmt->execute();
    }

    public function updateReadingWishlist($id, $userId, $bookTitle, $author, $genre, $publicationYear, $reasonForReading)
    {
        $sql = "UPDATE reading_wishlist 
                SET user_id=?, book_title=?, author=?, genre=?, publication_year=?, reason_for_reading=?
                WHERE id_reading_wishlist=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssisi", $userId, $bookTitle, $author, $genre, $publicationYear, $reasonForReading, $id);
        return $stmt->execute();
    }

    public function deleteReadingWishlist($id)
    {
        $sql = "DELETE FROM reading_wishlist WHERE id_reading_wishlist=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>