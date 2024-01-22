<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
	// Récupération des données du formulaire
	$title = $_POST["titre"];
	$chapo = $_POST["chapo"];
	$content = $_POST["content"];
	$status = $_POST["status"];
	$pseudo = $_SESSION['user_pseudo']; // Récupération du pseudo de l'utilisateur connecté

	// Connexion à la base de données
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Erreur de connexion à la base de données : " . $e->getMessage();
		exit();
	}

	// Requête pour récupérer l'ID de l'utilisateur à partir du pseudo
	$userQuery = $pdo->prepare("SELECT id FROM user WHERE pseudo = ?");
	$userQuery->execute([$pseudo]);
	$user = $userQuery->fetch(PDO::FETCH_ASSOC);

	if ($user && isset($user['id'])) {
		$authorId = $user['id'];

		// Traitement de l'image téléchargée
		$uploadDirectory = 'assets/images/uploads/';
		$uploadedFileName = $_FILES['image']['name'];
		$targetFilePath = $uploadDirectory . $uploadedFileName;

		// Déplacer l'image téléchargée vers le répertoire cible
		if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
			try {
				// Utilisation du chemin relatif pour enregistrer dans la base de données
				$relativeImagePath = $uploadDirectory . $uploadedFileName;

				$query = $pdo->prepare("INSERT INTO articles (title, chapo, content, status, author, image_path) VALUES (?, ?, ?, ?, ?, ?)");
				$query->execute([$title, $chapo, $content, $status, $authorId, $relativeImagePath]);

				// Redirection vers ../admin_home.php
				header("Location: admin_home");
				exit();
			} catch (PDOException $e) {
				echo "Une erreur est survenue lors de l'ajout de l'article : " . $e->getMessage();
				// Gérer l'erreur ou rediriger vers une page d'échec si nécessaire
			}
		} else {
			echo "Erreur lors du téléchargement de l'image, l'image doit faire moins de 2mo";
			echo '<a href=/>Accueil</a>';
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
