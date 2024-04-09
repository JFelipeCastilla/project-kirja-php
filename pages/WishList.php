<?php 
session_start();

// Use database
require_once "../includes/Database.php";

$user = null;

// Check if a session variable called "user_id" exists
if (isset($_SESSION["user_id"])) {
    // Create a new Database instance
    $database = new Database("127.0.0.1", "root", "123456", "kirja");
    $conn = $database->getConnection();

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

// if "user_id" no exists so redirect to dashboard
else {
    header("Location: ../index.php");
    exit();
}
?>

<?php include("../templates/header.php") ?>
    <?php include("../templates/navbar.php") ?>
    <?php if (!empty($user)): ?>
    <div class="container-body">
        <div class="container-table">
            <h1>Reading Wishlist</h1>
            <button type="button" class="button" onclick="openModal('addPreference')">Agregar Libro</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Publication Year</th>
                        <th>Reason for Reading</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        // Select wishlist items for the current user
                        $query = "SELECT * FROM reading_wishlist WHERE user_id = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $_SESSION["user_id"]);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row["id_reading_wishlist"] ?></td>
                                <td><?php echo $row["book_title"] ?></td>
                                <td><?php echo $row["author"] ?></td>
                                <td><?php echo $row["genre"] ?></td>
                                <td><?php echo $row["publication_year"] ?></td>
                                <td><?php echo $row["reason_for_reading"] ?></td>
                                <td class="actions">
                                <button class="edit-button" onclick="openEditModal(<?php echo $row["id_reading_wishlist"]; ?>, 'wishlist')">Edit</button>
                                    <form action="../includes/WishList/deleteWishlist.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row["id_reading_wishlist"]; ?>">
                                        <button type="submit" class="delete-button">Delete</button>
                                    </form>
                                </td>
                            </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div id="addPreference" class="modal">
        <div class="modal-content">
            <div class="top-content">
                <h2 class="title">Add Preference</h2>
                <span class="close" onclick="closeModal('addPreference')">&times;</span>
            </div>
            <form class="form-content" action="../includes/WishList/createWishlist.php" method="POST">
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
                    <label for="publication_year">Publication Year:</label>
                    <input class="input-modal" type="number" id="publication_year" name="publication_year">
                </div>
                <div class="input-content">
                    <label for="reason_for_reading">Reason for reading:</label>
                    <textarea id="reason_for_reading" name="reason_for_reading"></textarea>
                </div>
                <div class="input-content">
                    <input type="submit" value="Agregar">
                </div>
            </form>
        </div>
    </div>
    <div id="editPreference" class="modal">
        <div class="modal-content">
            <div class="top-content">
                <h2 class="title">Edit Preference</h2>
                <span class="close" onclick="closeModal('editPreference')">&times;</span>
            </div>
            <form class="form-content" action="../includes/WishList/editWishlist.php" method="POST">
                <input type="hidden" id="edit_id_reading_wishlist" name="id_reading_wishlist" value="">
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
                    <label for="publication_year">Publication Year:</label>
                    <input class="input-modal" type="number" id="publication_year" name="publication_year">
                </div>
                <div class="input-content">
                    <label for="reason_for_reading">Reason for reading:</label>
                    <textarea id="reason_for_reading" name="reason_for_reading"></textarea>
                </div>
                <div class="input-content">
                    <button class="update-button" type="submit" name="update">Update</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif ?>
<?php include("../templates/footer.php") ?> 