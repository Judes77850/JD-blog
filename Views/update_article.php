<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
	$article_id = $_POST["article_id"];
	$title = $_POST["title"];
	$content = $_POST["content"];
	$status = $_POST["status"];

	try {
		$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo "Erreur de connexion à la base de données : " . $e->getMessage();
		exit();
	}

	if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
		$image = $_FILES["image"];
		$uploadDirectory = 'assets/images/uploads/';
		$uploadedFileName = $image['name'];
		$targetFilePath = $uploadDirectory . $uploadedFileName;

		if (move_uploaded_file($image["tmp_name"], $targetFilePath)) {
			$image_path = $targetFilePath;

			try {
				$query = $pdo->prepare("UPDATE articles SET title = ?, content = ?, image_path = ?, status = ? WHERE id = ?");
				$query->execute([$title, $content, $image_path, $status, $article_id]);
				header("Location: /admin_blog_list");
				exit();
			} catch (PDOException $e) {
				echo "Erreur lors de la mise à jour de l'article : " . $e->getMessage();
			}
		} else {
			echo "Erreur lors du téléchargement de l'image.";
		}
	} else {
		try {
			$query = $pdo->prepare("UPDATE articles SET title = ?, content = ?, status = ? WHERE id = ?");
			$query->execute([$title, $content, $status, $article_id]);
			header("Location: /admin_blog_list");
			exit();
		} catch (PDOException $e) {
			echo "Erreur lors de la mise à jour de l'article : " . $e->getMessage();
		}
	}
} else {
	header("Location: erreur.php");
	exit();
}
