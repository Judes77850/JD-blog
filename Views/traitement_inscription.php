<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Récupération des données du formulaire
	$firstname = $_POST["prenom"];
	$lastname = $_POST["nom"];
	$pseudo = $_POST["pseudo"];
	$email = $_POST["email"];
	$password = $_POST["password"];

	// Hachage du mot de passe
	$password_hashed = password_hash($password, PASSWORD_DEFAULT);

	// Connexion à la base de données
	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

	// Préparation de la requête pour insérer l'utilisateur
	$query = $pdo->prepare("INSERT INTO user (firstname, lastname, pseudo, email, password) VALUES (?, ?, ?, ?, ?)");

	// Vérification de l'insertion réussie (facultatif)
	$success = $query->execute([$firstname, $lastname, $pseudo, $email, $password_hashed]);

	// Vérification de l'insertion réussie
	if ($success) {
		echo "Inscription réussie pour l'utilisateur : " . $pseudo;
		echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 2000);</script>";
		// Redirection vers une page de succès ou autre action si nécessaire
	} else {
		echo "Une erreur est survenue lors de l'inscription.";
		// Gérer l'erreur ou rediriger vers une page d'échec si nécessaire
	}
}

