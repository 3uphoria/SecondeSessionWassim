<?php
session_start();

// Vérification si l'utilisateur est connecté et a le rôle admin
if (!isset($_SESSION["user_id"]) || $_SESSION["admin"] !== 1) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page Admin</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Page Admin</h1>
        <p>Bienvenue, administrateur !</p>
        <p>Contenu de la page réservé aux administrateurs.</p>
        <p><a href="logout.php">Se déconnecter</a></p>
    </div>
</body>
</html>
