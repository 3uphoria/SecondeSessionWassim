<?php
require_once "config.php";
session_start();

// Si l'utilisateur est déjà connecté, redirigez-le vers sa page de profil
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: profil.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT username, password FROM user WHERE username = '$username'";
    $result = $conn->query($sql);
print_r ($result);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        print_r ($row);
        if (md5($password) == $row["password"]) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row["id"];
            header("location: profil.php");
            exit;
        } else {
            $login_error = "Mot de passe incorrect.";
        }
    } else {
        $login_error = "Nom d'utilisateur incorrect.";
    }
}
$pages = array(
    "Accueil" => "index.php",
    "Liste des cours" => "course.php",
    "Profil" => "profil.php",
    "Login" => "login.php"
);
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $pages += [ "Logout" => "logout.php" ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        <h1>Connexion</h1>
        
        <?php
        if (isset($login_error)) {
            echo '<p class="error">' . $login_error . '</p>';
        }

        echo '<form method="post">';
        echo '<label for="username">Nom d\'utilisateur</label>';
        echo '<input type="text" id="username" name="username" required><br>';
        echo '<label for="password">Mot de passe</label>';
        echo '<input type="password" id="password" name="password" required><br>';
        echo '<input type="submit" value="Se connecter">';
        echo '</form>';
        
        echo '<p>Pas encore de compte? <a href="register.php">Créez-en un ici</a>.</p>';
        ?>
    </div>
</body>
</html>

