<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
	// Récupération des données du formulaire
	$title = $_POST["titre"];
	$chapo = $_POST["chapo"];
	$content = $_POST["contenu"];
	$status = $_POST["status"];
	$pseudo = $_SESSION['pseudo']; // Récupération du pseudo de l'utilisateur connecté

	// Connexion à la base de données
	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

	// Requête pour récupérer l'ID de l'utilisateur à partir du pseudo
	$userQuery = $pdo->prepare("SELECT id FROM user WHERE pseudo = ?");
	$userQuery->execute([$pseudo]);
	$user = $userQuery->fetch(PDO::FETCH_ASSOC);

	if ($user && isset($user['id'])) {
		$authorId = $user['id'];

		// Préparation de la requête pour insérer un nouvel article
		$query = $pdo->prepare("INSERT INTO articles (title, chapo, content, status, author) VALUES (?, ?, ?, ?, ?)");
		$query->execute([$title, $chapo, $content, $status, $authorId]);

		// Vérification de l'insertion réussie
		if ($query) {
			echo "L'article a été ajouté avec succès !";

			// Attendre 2 secondes avant la redirection
			usleep(200000); // 2 secondes = 2 000 000 microsecondes

			// Redirection vers ../admin_home.php après 2 secondes
			header("Location: admin/admin_home.php");
		} else {
			echo "Une erreur est survenue lors de l'ajout de l'article.";
			// Gérer l'erreur ou rediriger vers une page d'échec si nécessaire
		}
	} else {
		// Gérer le cas où l'auteur n'est pas trouvé
		echo "Auteur non trouvé";
	}
} else {
	// Redirection vers une page d'erreur si l'utilisateur n'est pas connecté ou si la méthode de requête est incorrecte
	header("Location: erreur.php");
	exit();
}

?>
