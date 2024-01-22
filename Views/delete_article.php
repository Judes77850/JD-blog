<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	// Redirection vers la page de connexion si utilisateur pas connecté
	header("Location: login.php");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['article_id'])) {
	// Récupération de l'identifiant article à supprimer depuis le formulaire
	$article_id = $_POST['article_id'];

	// Connexion à la base de données
	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

	// Préparation de la requête pour supprimer l'article
	$query = $pdo->prepare("DELETE FROM articles WHERE id = ? AND author = ?");
	$query->execute([$article_id, $_SESSION['user_id']]);

	// Redirection page d'administration après la suppression
	header("Location: admin_blog_list");
	exit();
} else {
	// Redirection vers page d'erreur si l'identifiant de l'article n'est pas présent ou si méthode de requête hs
	header("Location: erreur.php");
	exit();
}

