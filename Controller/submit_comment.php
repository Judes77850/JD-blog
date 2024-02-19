<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	die();
	if (isset($_POST["content"]) && !empty($_POST["content"])) {
		$content = $_POST["content"];
		$postId = $_POST["article_id"];
		$userId = $_POST["user_id"];

	} else {
		echo "Erreur : Le champ de contenu du commentaire est vide.";
	}
} else {
	header("Location: error.php");
	exit;
}