<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Récupération des données du formulaire
	$email = $_POST["email"];
	$password = $_POST["password"];
	$pseudo = $_POST["pseudo"];

	// Connexion à la base de données
	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

	// Préparation de la requête pour vérifier l'utilisateur
	$query = $pdo->prepare("SELECT * FROM user WHERE email = ?");
	$query->execute([$email]);
	$user = $query->fetch(PDO::FETCH_ASSOC);

	// Vérification du mot de passe
	if ($user && password_verify($password, $user['password'])) {
		// L'utilisateur existe et le mot de passe correspond
		$_SESSION['user_id'] = $user['id']; // Stocker l'identifiant de l'utilisateur
		$_SESSION['user_email'] = $user['email']; // Stocker l'email de l'utilisateur, etc.
		$_SESSION['user_firstname'] = $user['firstname'];
		$_SESSION['user_lastname'] = $user['lastname'];
		$_SESSION['user_pseudo'] = $user['pseudo'];
		// Redirection vers une page de succès
		header("Location: page_success.php");
		exit();
	} else {
		// Identifiants incorrects ou utilisateur inexistant
		header("Location: page_echec.php");
		exit();
	}
}

