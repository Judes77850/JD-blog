<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit();
}

if (!isset($_POST['article_id'])) {
	header("Location: edit_single_article");
	exit();
}

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

// Récupérer les données du formulaire
$article_id = $_POST['article_id'];
$title = $_POST['title'];
$content = $_POST['content'];
$status = $_POST['status'];
$image_path = $_POST['image_path'];
$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM articles WHERE id = ? AND author = ?");
$query->execute([$article_id, $user_id]);
$article = $query->fetch(PDO::FETCH_ASSOC);

if (!$article) {
	// Redirection si l'article n'appartient pas à l'utilisateur connecté
	header("Location: edit_single_article");
	exit();
}

$updateQuery = $pdo->prepare("UPDATE articles SET title = ?, content = ?, status = ?, image_path = ? WHERE id = ?");
$updateQuery->execute([$title, $content, $status, $image_path, $article_id]);

header("Location: admin_blog_list");
exit();

