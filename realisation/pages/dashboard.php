<?php
session_start();
require '../config/connexion.php';
require '../includes/article.php';

// Check if user is Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$post_obj = new Article($db);


$posts = $post_obj->getAllAdmin();





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tangier Vibes</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin_container">
        <div class="admin_header">
            <h1>Manage Posts</h1>
            <div>
                <a href="../pages/index.php" style="margin-right: 20px;">Back to Site</a>
                <a href="add_post.php" class="btn_add">Add New Post</a>
            </div>
        </div>

        
            
       

        <table class="admin_table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= htmlspecialchars($post['title']) ?></td>
                    <td><?= htmlspecialchars($post['cat_name']) ?></td>
                    <td><?= date('M j, Y', strtotime($post['created_at'])) ?></td>
                    
                    <td>
                        <a href="edit_post.php?id=<?= $post['id'] ?>" class="btn_edit" style="margin-right: 10px; color: #2563eb; text-decoration: none; font-weight: 500;">Edit</a>
                        <a href="delete.php?id=<?= $post['id'] ?>" class="btn_delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
