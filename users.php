<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}
include 'db.php';

$sql = "SELECT users.id AS id, users.username, users.created_at AS user_created_at, tasks.description AS task_description, tasks.created_at AS task_created_at
        FROM users
        LEFT JOIN tasks ON users.id = tasks.id
        ORDER BY users.id, tasks.created_at DESC";

$result = $conn->query($sql);
if (!$result) {
    echo "Erreur MySQL : " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Liste des Utilisateurs et leurs Tâches</h1>
    </header>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID Utilisateur</th>
                    <th>Nom d'utilisateur</th>
                    <th>Date de création utilisateur</th>
                    <th>Description de la tâche</th>
                    <th>Date de création de la tâche</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['username']) . "</td>
                                <td>" . date('d/m/Y H:i', strtotime($row['user_created_at'])) . "</td>
                                <td>" . htmlspecialchars($row['task_description']) . "</td>
                                <td>" . date('d/m/Y H:i', strtotime($row['task_created_at'])) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No user found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <a href="task.php" class="btn">Retour à la page des tâches</a>

    <footer>
        <p>&copy; 2024 Gestion de To-Do List. Tous droits réservés.</p>
    </footer>
</body>

</html>

<?php
$conn->close();
?>