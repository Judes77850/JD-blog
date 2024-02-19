<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['article_id'])) {
	$article_id = $_POST['article_id'];

	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

	$query = $pdo->prepare("DELETE FROM articles WHERE id = ? AND author = ?");
	$query->execute([$article_id, $_SESSION['user_id']]);

	header("Location: admin_blog_list");
	exit();
} else {
	header("Location: erreur.php");
	exit();
}

