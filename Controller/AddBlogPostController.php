<?php

namespace Controller;

use Model\ArticleModel;

class AddBlogPostController
{
	private $articleModel;

	public function __construct(ArticleModel $articleModel)
	{
		$this->articleModel = $articleModel;
	}

	public function index()
	{
		// Affichez le formulaire d'ajout d'article
		require_once __DIR__ . '../Views/add_blog_article.php';
	}

	public function addBlogPost()
	{
		// Gérez ici la logique pour ajouter un nouvel article
		// Récupérez les données du formulaire
		$title = $_POST['title'];
		$chapo = $_POST['chapo'];
		$content = $_POST['content'];
		$author = $_POST['author'];
		$status = $_POST['status'];

		// Vous pouvez utiliser le modèle pour interagir avec la base de données et ajouter l'article
		$this->articleModel->addArticle($title, $chapo, $content, $author, $status);

		// Redirigez ensuite l'utilisateur vers la liste des articles ou effectuez une autre action appropriée
		header("Location: articles");
		exit();
	}
}
