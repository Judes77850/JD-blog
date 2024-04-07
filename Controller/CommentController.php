<?php

require_once __DIR__ . '/../Model/CommentModel.php';

class CommentController
{
	public function showComments($articleId)
	{
		$pdo = DatabaseManager::getPdoInstance();
		$commentModel = new \Model\CommentModel($pdo);
		$comments = $commentModel->getCommentsByArticleId($articleId);
		$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin';
		$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
		$twig = new \Twig\Environment($loader);

		if (isset($_SESSION['user_id'])) {
			$template = $twig->load('comment.twig');
			echo $template->render(['comments' => $comments, 'is_admin' => $is_admin, 'article_id' => $articleId]);
		}

	}

	public function submitComment($articleId)
	{

		if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['user_id']) {
			if (isset($_POST["content"]) && !empty($_POST["content"])) {
				$content = $_POST["content"];
				$userId = $_SESSION['user_id'];

				$pdo = DatabaseManager::getPdoInstance();
				$commentModel = new \Model\CommentModel($pdo);

				$success = $commentModel->saveComment($articleId, $content, $userId);

				if ($success) {
					header("refresh:1;url=/article?id=" . $articleId);
					echo "Commentaire ajouté avec succès. Vous serez redirigé vers la page de l'article dans un instant...";
					exit();
				} else {
					echo "Erreur : Impossible d'ajouter le commentaire pour l'article avec l'ID : " . $articleId;
				}
			} else {
				echo "Erreur : Le champ de contenu du commentaire est vide.";
			}
		} else {
			header("Location: error.php");
			exit;
		}
	}

	public function deleteComment($articleId, $commentId)
	{

		if ($_SESSION['user_role'] == 'admin') {
			$pdo = DatabaseManager::getPdoInstance();
			$commentModel = new \Model\CommentModel($pdo);
			$success = $commentModel->deleteComment($commentId);

			if ($success) {
				header("refresh:1;url=/article?id=" . $articleId);
				echo "Le commentaire a été supprimé avec succès.";
			} else {
				echo "Une erreur s'est produite lors de la suppression du commentaire.";
			}
		} else {
			echo "Vous n'avez pas les autorisations nécessaires pour effectuer cette action.";
		}
	}

}
