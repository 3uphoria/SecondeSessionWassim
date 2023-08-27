<?php
session_start();

// Déconnexion de l'utilisateur
unset($_SESSION["user_id"]);

// Redirection vers la page de login
header("Location: index.php");
exit();
?>
