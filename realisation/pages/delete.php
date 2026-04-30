<?php
session_start();
require '../config/connexion.php';
require '../includes/article.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Error: Access Denied!");
}

$database = new Database();
$db = $database->getConnection();
$article_obj = new Article($db);

if (isset($_GET['id'])) {
    if ($article_obj->delete($_GET['id'])) {
        header("Location: dashboard.php");
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>
