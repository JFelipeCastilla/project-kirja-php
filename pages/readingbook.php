<?php
session_start();
// Use database
require "../includes/database.php";

$user = null;

// Check if session is started
if (isset($_SESSION["user_id"])) {
    // Select user information
    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE id = ?");
    // Prepare a SQL statement with an integer parameter
    $stmt->bind_param("i", $_SESSION["user_id"]);
    // Execute the prepared SQL statement
    $stmt->execute();
    // Get the result of the executed query
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}

// SQL query to select data from reading_progress table for the current user
$query = "SELECT * FROM reading_progress WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all rows from the result into an array
$reading_progress_array = [];
while ($row = $result->fetch_assoc()) {
    $reading_progress_array[] = $row;
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
                    <!-- PHP code to display reading progress data -->
                    <?php foreach ($reading_progress_array as $row) { ?>
                        <tr>
                            <td><?php echo $row["id_reading_progress"]; ?></td>
                            <td><?php echo $row["book_title"]; ?></td>
                            <td><?php echo $row["author"]; ?></td>
                            <td><?php echo $row["genre"]; ?></td>
                            <td><?php echo $row["start_date"]; ?></td>
                            <td><?php echo $row["end_date"]; ?></td>
                            <td class="actions">
                                <button class="edit-button" onclick="openEditModal(<?php echo $row["id_reading_progress"]; ?>)">Edit</button>
                                <form action="../includes/deleteProgress.php" method="POST"> <!-- Cambiado el nombre del script de eliminación -->
                                    <input type="hidden" name="id_reading_progress" value="<?php echo $row["id_reading_progress"]; ?>">
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
            <form class="form-content" action="../includes/createProgress.php" method="POST">
                <div class="input-content">
                    <label for="book_title">Título:</label>
                    <input class="input-modal" type="text" id="book_title" name="book_title" required>
                </div>
                <div class="input-content">
                    <label for="author">Autor:</label>
                    <input class="input-modal" type="text" id="author" name="author" required>
                </div>
                <div class="input-content">
                    <label for="genre">Género:</label>
                    <input class="input-modal" type="text" id="genre" name="genre">
                </div>
                <div class="input-content">
                    <label for="start_date">Fecha de inicio:</label>
                    <input class="input-modal" type="date" id="start_date" name="start_date" required>
                </div>
                <div class="input-content">
                    <label for="end_date">Fecha de fin:</label>
                    <input class="input-modal" type="date" id="end_date" name="end_date" required>
                </div>
                <div class="input-content">
                    <input type="submit" value="Agregar">
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para editar progreso -->
    <div id="modelProgress" class="modal">
        <div class="modal-content">
            <div class="top-content">
                <h2 class="title">Edit Book</h2>
                <span class="close" onclick="closeModal('modelProgress')">&times;</span>
            </div>
            <form class="form-content" action="../includes/editProgress.php" method="POST">
                <input type="hidden" id="edit_id_reading_progress" name="id_reading_progress" value="">
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
                    <button class="update-button" type="submit" name="update">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id) {
            document.getElementById('modelProgress').style.display = 'block'
            document.getElementById('edit_id_reading_progress').value = id;
        }
    </script>
<?php include("../templates/footer.php") ?>