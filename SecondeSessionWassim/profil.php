<?php
    require_once "config.php";
    session_start();

    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("location: login.php");
        exit;
    }

    $user_id = $_SESSION["id"];
    $sql_user = "SELECT * FROM user WHERE id = $user_id";
    $result_user = $conn->query($sql_user);
    $user_data = $result_user->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_username = $_POST["username"];
        $new_email = $_POST["email"];
        $new_password = $_POST["password"];

        if (!empty($new_password)) {
            // Hashage simplifié du mot de passe (ne pas utiliser en production)
            $hashed_password = md5($new_password);
            $sql_update_password = "UPDATE user SET password = '$hashed_password' WHERE id = $user_id";
            $conn->query($sql_update_password);
        }

        $sql_update_info = "UPDATE user SET username = '$new_username', email = '$new_email' WHERE id = $user_id";
        $conn->query($sql_update_info);

        // Gérer ici la mise à jour des cours sélectionnés par l'utilisateur dans la base de données
        if (isset($_POST["courses"]) && is_array($_POST["courses"])) {
            // Supprimer les anciennes sélections
            $sql_delete_old_selections = "DELETE FROM user_course WHERE user_id = $user_id";
            $conn->query($sql_delete_old_selections);

            // Insérer les nouvelles sélections
            foreach ($_POST["courses"] as $course_id) {
                $sql_insert_selection = "INSERT INTO user_course (user_id, course_id) VALUES ($user_id, $course_id)";
                $conn->query($sql_insert_selection);
            }
        }
    }

    $sql_courses = "SELECT * FROM course";
    $result_courses = $conn->query($sql_courses);

    // Récupérer les cours sélectionnés par l'utilisateur
    $sql_user_courses = "SELECT course_id FROM user_course WHERE user_id = $user_id";
    $result_user_courses = $conn->query($sql_user_courses);
    $user_selected_courses = [];
    while ($row = $result_user_courses->fetch_assoc()) {
        $user_selected_courses[] = $row["course_id"];
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
        echo '<h1>Profil</h1>';

        echo '<form method="post">';
        echo '<label for="username">Nom d\'utilisateur</label>';
        echo '<input type="text" id="username" name="username" value="' . $user_data["username"] . '" required><br>';
        echo '<label for="email">Adresse e-mail</label>';
        echo '<input type="email" id="email" name="email" value="' . $user_data["email"] . '" required><br>';
        echo '<label for="password">Nouveau mot de passe</label>';
        echo '<input type="password" id="password" name="password"><br>';

        echo '<h2>Cours disponibles :</h2>';
        while ($course = $result_courses->fetch_assoc()) {
            echo '<div>';
            
            echo '<input type="checkbox" name="courses[]" value="' . $course["id"] . '"';
            if (in_array($course["id"], $user_selected_courses)) {
                echo ' checked';
            }
            echo '> ';
            echo '<label>' . $course["name"] . '</label>' ;
            echo '</div>';
        }

        echo '<input type="submit" value="Enregistrer les modifications">';
        echo '</form>';
        
        echo '</div>';
    ?>
</body>
</html>
