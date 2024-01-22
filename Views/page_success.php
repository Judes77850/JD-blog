<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Connexion approuvée</title>
	<!-- Vous pouvez inclure ici vos liens vers des fichiers CSS, des scripts JavaScript, etc. -->
</head>
<body>
<h1>Connexion approuvée</h1>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_SESSION['user_id'])) {
	try {
		// Connexion à la base de données
        $pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');
		$user_id = $_SESSION['user_id'];

		// Exécution de la requête SQL pour récupérer le prénom de l'utilisateur
		$query = $pdo->prepare("SELECT pseudo FROM user WHERE id = ?");
		$query->execute([$user_id]);
		$user = $query->fetch(PDO::FETCH_ASSOC);

		if ($user && isset($user['pseudo'])) {
			$_SESSION['pseudo'] = $user['pseudo'];
			echo "Hello, " . $_SESSION['pseudo'];
		} else {
			echo "Hello";
		}
	} catch (PDOException $e) {
		echo "Erreur de connexion à la base de données : " . $e->getMessage();
	}
}



?>
<p><a href="home.php">Accueil</a></p>
<p><a href="admin/admin_home.php">Mon compte</a></p>
<!-- Autres contenus ou liens -->
</body>
</html>
