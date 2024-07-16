<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}


$user_id = $_SESSION['id'];

include ("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    
    $sql_tasks = "DELETE FROM tasks WHERE category_id = ? AND user_id = ?";
    $stmt_tasks = $conn->prepare($sql_tasks);
    $stmt_tasks->bind_param("ii", $category_id, $user_id);
    $stmt_tasks->execute();
    $stmt_tasks->close();

    
    $sql_category = "DELETE FROM categories WHERE id = ? AND user_id = ?";
    $stmt_category = $conn->prepare($sql_category);
    $stmt_category->bind_param("ii", $category_id, $user_id);
    $stmt_category->execute();
    $stmt_category->close();

    
    header("Location: task.php");
    exit();
}


$conn->close();
?>