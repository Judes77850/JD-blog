<?php

require_once __DIR__ . '/../Model/ArticleModel.php';
require_once __DIR__ . '/../DatabaseManager.php';
require_once __DIR__ . '/../Controller/CommentController.php';
require_once 'Views/header.php';
class ShowArticleController
{
	public function showArticle($articleId)
	{
		$pdo = DatabaseManager::getPdoInstance();

		if (!$pdo) {
			echo '<p>Erreur de connexion à la base de données.</p>';
			return;
		}

		$articleModel = new \Model\ArticleModel($pdo);
		$article = $articleModel->getArticleById($articleId);
		$commentController = new CommentController();



		if ($article) {
			require_once 'Views/show_article.php';
			$commentController->showComments($articleId);
		} else {
			echo '<p>Article non trouvé. 3</p>';
		}

		require_once 'Views/footer.php';
	}
}

