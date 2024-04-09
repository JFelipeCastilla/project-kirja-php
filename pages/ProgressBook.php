<?php
session_start();
require_once "../includes/Database.php";
require_once "../includes/ProgressBook/ProgressManager.php";

// Crear una nueva instancia de Database
$database = new Database("127.0.0.1", "root", "123456", "kirja");

// Crear una instancia de ProgressManager utilizando la base de datos
$progressManager = new ProgressManager($database);

// Verificar si la sesión está iniciada
if (isset($_SESSION["user_id"])) {
    // Obtener el progreso de lectura del usuario actual
    $reading_progress_array = $progressManager->viewProgress($_SESSION["user_id"]);
} else {
    // Si la sesión no está iniciada, redirigir al usuario a la página de inicio de sesión o mostrar un mensaje de error
}

?>

<?php include("../templates/header.php") ?>
    <?php include("../templates/navbar.php") ?>
    <div class="container-body">
        <div class="container-table">
            <h1>Reading Progress</h1>
            <button type="button" class="button" onclick="openModal('addProgress')">Create Book</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reading_progress_array as $row) { ?>
                        <tr>
                            <td><?php echo $row["id_reading_progress"]; ?></td>
                            <td><?php echo $row["book_title"]; ?></td>
                            <td><?php echo $row["author"]; ?></td>
                            <td><?php echo $row["genre"]; ?></td>
                            <td><?php echo $row["start_date"]; ?></td>
                            <td><?php echo $row["end_date"]; ?></td>
                            <td class="actions">
                                <button class="edit-button" onclick="openEditModal(<?php echo $row["id_reading_progress"]; ?>, 'progress')">Edit</button>
                                <form action="../includes/ProgressBook/deleteBook.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row["id_reading_progress"]; ?>">
                                    <button type="submit" class="delete-button">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar progreso -->
    <div id="addProgress" class="modal">
        <div class="modal-content">
            <div class="top-content">
                <h2 class="title">Create Book</h2>
                <span class="close" onclick="closeModal('addProgress')">&times;</span>
            </div>
            <form class="form-content" action="../includes/ProgressBook/createBook.php" method="POST">
                <div class="input-content">
                    <label for="book_title">Title:</label>
                    <input class="input-modal" type="text" id="book_title" name="book_title" required>
                </div>
                <div class="input-content">
                    <label for="author">Author:</label>
                    <input class="input-modal" type="text" id="author" name="author" required>
                </div>
                <div class="input-content">
                    <label for="genre">Genre:</label>
                    <input class="input-modal" type="text" id="genre" name="genre">
                </div>
                <div class="input-content">
                    <label for="start_date">Start Date:</label>
                    <input class="input-modal" type="date" id="start_date" name="start_date" required>
                </div>
                <div class="input-content">
                    <label for="end_date">End Date:</label>
                    <input class="input-modal" type="date" id="end_date" name="end_date" required>
                </div>
                <div class="input-content">
                    <button class="create-button" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar progreso -->
    <div id="editProgress" class="modal">
        <div class="modal-content">
            <div class="top-content">
                <h2 class="title">Edit Book</h2>
                <span class="close" onclick="closeModal('editProgress')">&times;</span>
            </div>
            <form class="form-content" action="../includes/ProgressBook/editBook.php" method="POST">
                <input type="hidden" id="edit_id_reading_progress" name="id_reading_progress" value="">
                <div class="input-content">
                    <label for="edit_book_title">Title:</label>
                    <input class="input-modal" type="text" id="edit_book_title" name="book_title" required>
                </div>
                <div class="input-content">
                    <label for="edit_author">Author:</label>
                    <input class="input-modal" type="text" id="edit_author" name="author" required>
                </div>
                <div class="input-content">
                    <label for="edit_genre">Genre:</label>
                    <input class="input-modal" type="text" id="edit_genre" name="genre">
                </div>
                <div class="input-content">
                    <label for="edit_start_date">Start Date:</label>
                    <input class="input-modal" type="date" id="edit_start_date" name="start_date" required>
                </div>
                <div class="input-content">
                    <label for="edit_end_date">End Date:</label>
                    <input class="input-modal" type="date" id="edit_end_date" name="end_date" required>
                </div>
                <div class="input-content">
                    <button class="update-button" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
<?php include("../templates/footer.php") ?>