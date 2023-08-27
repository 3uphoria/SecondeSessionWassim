<?php
    require_once "config.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        
        // Hashage simplifié du mot de passe (ne pas utiliser en production)
        $hashed_password = md5($password);

        // Vérifier s'il s'agit du premier utilisateur
        $sql_check_first_user = "SELECT COUNT(*) AS user_count FROM user";
        $result_check_first_user = $conn->query($sql_check_first_user);
        $user_count = $result_check_first_user->fetch_assoc()["user_count"];
        
        if ($user_count == 0) {
            $admin = 1; // Premier utilisateur est admin
        } else {
            $admin = 0; // Les autres utilisateurs ne sont pas admins
        }

        // Insertion de l'utilisateur dans la base de données avec le rôle
        $sql = "INSERT INTO user (username, password, email, created, lastlogin, admin) VALUES ('$username', '$hashed_password', '$email', NOW(), NOW(), $admin)";
        if ($conn->query($sql) === TRUE) {
            $success_message = "Compte créé avec succès.";
        } else {
            $error_message = "Erreur lors de la création du compte : " . $conn->error;
        }
    }
?>

<?php
    echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<?php
    echo '<!DOCTYPE html>';
?>
<html>
<head>
    <?php
        echo '<title>Inscription</title>';
        echo '<link rel="stylesheet" type="text/css" href="style.css">';
    ?>
</head>
<body>
    <?php
        echo '<nav>';
        echo '<ul>';
        echo '<li><a href="index.php">Accueil</a></li>';
        echo '<li><a href="course.php">Liste des cours</a></li>';
        echo '<li><a href="profil.php">Profil</a></li>';
        echo '<li><a href="admin.php">Admin</a></li>';
        echo '<li><a href="login.php">Login</a></li>';
        echo '<li><a href="logout.php">Logout</a></li>';
        echo '</ul>';
        echo '</nav>';
        echo '<div class="container">';
        echo '<h1>Inscription</h1>';

        if (isset($success_message)) {
            echo '<p class="success">' . $success_message . '</p>';
        }

        if (isset($error_message)) {
            echo '<p class="error">' . $error_message . '</p>';
        }

        echo '<form method="post">';
        echo '<input type="text" name="username" placeholder="Nom d\'utilisateur" required><br>';
        echo '<input type="password" name="password" placeholder="Mot de passe" required><br>';
        echo '<input type="email" name="email" placeholder="Adresse e-mail" required><br>';
        echo '<input type="submit" value="Créer un compte">';
        echo '</form>';
        echo '</div>';
    ?>
</body>
</html>
