<?php
require_once __DIR__. '/../Database.php';
require_once __DIR__. '/../ProgressBook/ProgressMethods.php';

class ProgressManager
{
    private $db;
    private $progressMethods;

    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->progressMethods = new ProgressMethods($db->getConnection());
    }

    public function viewProgress($userId)
    {
        return $this->progressMethods->viewReadingProgress($userId);
    }

    public function addProgress($userId, $bookTitle, $author, $genre, $startDate, $endDate)
    {
        return $this->progressMethods->createReadingProgress($userId, $bookTitle, $author, $genre, $startDate, $endDate);
    }

    public function updateProgress($id, $userId, $bookTitle, $author, $genre, $startDate, $endDate)
    {
        return $this->progressMethods->updateReadingProgress($id, $userId, $bookTitle, $author, $genre, $startDate, $endDate);
    }

    public function deleteProgress($id)
    {
        return $this->progressMethods->deleteReadingProgress($id);
    }

    // Agrega el método para obtener los detalles del progreso de lectura por ID
    public function getReadingProgressDetails($id)
    {
        return $this->progressMethods->getReadingProgressDetails($id);
    }
}
?>