<?php
    require_once "config.php";

    session_start();

    $user_id = $_SESSION["id"];
    $sql = "SELECT course_id FROM user_course WHERE user_id = $user_id";
    $result = $conn->query($sql);
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
        echo '<title>Liste des cours</title>';
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
        echo '<h1>Liste des cours</h1>';
        echo '<table>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nom du cours</th>';
        echo '<th>Code du cours</th>';
        echo '</tr>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["id"] . '</td>';
            echo '<td>' . $row["name"] . '</td>';
            echo '<td>' . $row["code"] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    ?>
</body>
</html>
