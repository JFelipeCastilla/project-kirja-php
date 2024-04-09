

<?php include("../templates/header.php") ?>
    <?php include("../templates/navbar.php") ?>
    <h2>Reading book</h2>
    <?php if (!empty($user)): ?>
        <h1>Profile</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created at</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $query = "SELECT * FROM users";
                    $users = mysqli_query($conn, $query);

                    while($row = mysqli_fetch_array($users)) { ?>
                        <tr>
                            <td><?php echo $row["id"] ?></td>
                            <td><?php echo $row["username"] ?></td>
                            <td><?php echo $row["email"] ?></td>
                            <td><?php echo $row["created_at"] ?></td>
                        </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php endif ?>
    </div>
<?php include("../templates/footer.php") ?>