<?php
session_start();
require "../includes/database.php";

session_unset();

session_destroy();

echo "Logout script executed"; // Debug message

header("Location: ../index.php");
exit(); // Terminate script execution after redirection
?>