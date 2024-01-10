<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	// Redirection vers la page de connexion si l'utilisateur n'est pas connecté
	header("Location: login.php");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['article_id'])) {
	// Récupération de l'identifiant de l'article à supprimer depuis le formulaire
	$article_id = $_POST['article_id'];

	// Connexion à la base de données
	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

	// Préparation de la requête pour supprimer l'article
	$query = $pdo->prepare("DELETE FROM articles WHERE id = ? AND author = ?");
	$query->execute([$article_id, $_SESSION['user_id']]);

	// Redirection vers la page d'administration après la suppression
	header("Location: /admin/admin_blog_list.php");
	exit();
} else {
	// Redirection vers une page d'erreur si l'identifiant de l'article n'est pas présent ou si la méthode de requête est incorrecte
	header("Location: erreur.php");
	exit();
}
?>
