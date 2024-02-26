<?php
session_start();

var_dump($_SESSION);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
	var_dump($_POST);

	$title = $_POST["titre"];
	$chapo = $_POST["chapo"];
	$content = $_POST["content"];
	$status = $_POST["status"];
	$pseudo = $_SESSION['user_pseudo'];
	$authorId = $_SESSION['user_id'];

	try {
		$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Erreur de connexion à la base de données : " . $e->getMessage();
		exit();
	}

	$userQuery = $pdo->prepare("SELECT id FROM user WHERE pseudo = ?");
	var_dump($userQuery);

	$userQuery->execute([$pseudo]);
	$user = $userQuery->fetch(PDO::FETCH_ASSOC);

	var_dump($user);

	if ($user && isset($user['id'])) {

		$uploadDirectory = 'assets/images/uploads/';
		$uploadedFileName = $_FILES['image']['name'];
		$targetFilePath = $uploadDirectory . $uploadedFileName;

		if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
			try {
				$relativeImagePath = $uploadDirectory . $uploadedFileName;

				$query = $pdo->prepare("INSERT INTO articles (title, chapo, content, status, author, image_path) VALUES (?, ?, ?, ?, ?, ?)");
				$query->execute([$title, $chapo, $content, $status, $authorId, $relativeImagePath]);

				header("Location: admin_home");
				exit();
			} catch (PDOException $e) {
				echo "Une erreur est survenue lors de l'ajout de l'article : " . $e->getMessage();
			}
		} else {
			echo "Erreur lors du téléchargement de l'image, l'image doit faire moins de 2mo";
			echo '<a href=/>Accueil</a>';
		}
	} else {
		echo "Auteur non trouvé";
	}
} else {
	header("Location: erreur.php");
	exit();
}
?>
