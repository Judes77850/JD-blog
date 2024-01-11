<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	// Redirection vers la page de connexion si utilisateur pas connecté
	header("Location: login.php");
	exit();
}

// Vérification si le formulaire est soumis et les données nécessaires sont ok
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'], $_POST['content'], $_POST['status'], $_POST['article_id'])) {
	// Connexion bdd
	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

	// Récupération des données formulaire
	$article_id = $_POST['article_id'];
	$title = $_POST['title'];
	$content = $_POST['content'];
	$status = $_POST['status'];

	// Vérification si l'article appartient à l'utilisateur connecté
	$user_id = $_SESSION['user_id'];
	$query = $pdo->prepare("SELECT * FROM articles WHERE id = ? AND author = ?");
	$query->execute([$article_id, $user_id]);
	$article = $query->fetch(PDO::FETCH_ASSOC);

	if ($article) {
		// Mise à jour de l'article dans la base de données
		$updateQuery = $pdo->prepare("UPDATE articles SET title = ?, content = ?, status = ? WHERE id = ?");
		$updateQuery->execute([$title, $content, $status, $article_id]);


		// Redirection vers la page d'édition des articles après la mise à jour
		header("Location: edit_article.php");
		exit();
	} else {
		// Redirection si l'article n'appartient pas à l'utilisateur connecté
		header("Location: edit_article.php");
		exit();
	}
} else {
	// Redirection si les données du formulaire hs ou si la méthode de requête est hs
	header("Location: edit_article.php");
	exit();
}

