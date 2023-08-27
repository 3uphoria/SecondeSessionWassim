<?php
session_start();

    $pages = array(
        "Accueil" => "index.php",
        "Liste des cours" => "course.php",
        "Profil" => "profil.php",
        "Login" => "login.php"
    );
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $pages += [ "Logout" => "logout.php" ];
    }
    if (isset($_SESSION["user_id"]) || $_SESSION["admin"] == 1) {
        $pages += [ "Admin" => "admin.php" ];
    }
    print_r ($_SESSION)

?>

<!DOCTYPE html>
<html>
<head>
    <title>Examen Script Serveur</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <nav>
        <ul>
            <?php
                foreach ($pages as $label => $link) {
                    echo "<li><a href=\"$link\">$label</a></li>";
                }
            ?>
        </ul>
    </nav>
    <div class="container">
        <h1>Bienvenue à l'Examen de Seconde Session</h1>
        <p>Découvrez le monde passionnant de la programmation côté serveur. Plongez dans le code, explorez les cours et perfectionnez votre profil. Avec notre interface conviviale, l'apprentissage devient une aventure.</p>
    </div>
</body>
</html>
