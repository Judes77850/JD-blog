<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Récupération des données du formulaire
	$firstname = $_POST["prenom"];
	$lastname = $_POST["nom"];
	$pseudo = $_POST["pseudo"];
	$email = $_POST["email"];
	$password = $_POST["password"];

	$password_hashed = password_hash($password, PASSWORD_DEFAULT);

	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

	$query = $pdo->prepare("INSERT INTO user (firstname, lastname, pseudo, email, password) VALUES (?, ?, ?, ?, ?)");

	$success = $query->execute([$firstname, $lastname, $pseudo, $email, $password_hashed]);

	if ($success) {
		echo "Inscription réussie pour l'utilisateur : " . $pseudo;
		echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 2000);</script>";
	} else {
		echo "Une erreur est survenue lors de l'inscription.";
	}
}

