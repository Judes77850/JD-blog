<?php

namespace Controller;

use Model\Article;

class BlogController
{
	private $articleModel;

	public function __construct(\PDO $pdo)
	{
		$this->articleModel = new Article($pdo);
	}

	public function index()
	{
		// Appeler la méthode pour récupérer les articles
		$articles = $this->articleModel->getPublishedArticles();

		// Passer les articles à la vue
		include __DIR__ . '/../Views/blog_list.php';
	}
}

