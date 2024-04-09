<?php

require_once __DIR__. '/../Database.php';
require_once __DIR__. '/../Methods/WishlistMethods.php';

class WishlistManager
{
    private $db;
    private $wishlistMethods;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->wishlistMethods = new WishlistMethods($db->getConnection());
    }

    public function viewWishlist($userId)
    {
        return $this->wishlistMethods->viewReadingWishlist($userId);
    }

    public function addWishlistItem($userId, $bookTitle, $author, $genre, $publicationYear, $reasonForReading)
    {
        return $this->wishlistMethods->createReadingWishlist($userId, $bookTitle, $author, $genre, $publicationYear, $reasonForReading);
    }

    public function updateWishlistItem($id, $userId, $bookTitle, $author, $genre, $publicationYear, $reasonForReading)
    {
        return $this->wishlistMethods->updateReadingWishlist($id, $userId, $bookTitle, $author, $genre, $publicationYear, $reasonForReading);
    }

    public function deleteWishlistItem($id)
    {
        return $this->wishlistMethods->deleteReadingWishlist($id);
    }
}
?>