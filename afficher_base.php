<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style_bdd.css">
    <title>Data Base</title>


<body>
    <h2>Data Base</h2>
    <?php
    include 'db.php';

    $sql = "SELECT * FROM tasks WHERE deleted_at IS NULL ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
            <tr>
                <th>ID</th>
                <th>Task name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Creation date</th>
                <th>End date</th>
            </tr>";
        while ($row = $result->fetch_assoc()) {
            $taskId = $row['id'];
            $taskName = htmlspecialchars($row['description']);
            $taskDescription = htmlspecialchars($row['task_description']);
            $taskState = $row['state'];
            $createdAt = date('d/m/Y H:i', strtotime($row['created_at']));
            $completedAt = $row['completed_at'] ? date('d/m/Y H:i', strtotime($row['completed_at'])) : '-';
            echo "<tr>
                <td>$taskId</td>
                <td>$taskName</td> 
                <td>$taskDescription</td>
                <td>$taskState</td>
                <td>$createdAt</td>
                <td>$completedAt</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No task found.</p>";
    }
    ?>

    <a href="task.php">Go back</a>
</body>

</html>