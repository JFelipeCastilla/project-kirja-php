<?php
session_start();

// Check if a session variable called "user_id" exists
if (isset($_SESSION["user_id"])) {
    header("Location: ../kirja/pages/interface.php");
    exit();
}
?>


<?php include("templates/header.php") ?>

    <h1>Kirja</h1>
    <a href="auth/register.php"><span>Registrarse</span></a>
    <a href="auth/login.php"><span>Ingresar</span></a>

<?php include("templates/footer.php") ?>