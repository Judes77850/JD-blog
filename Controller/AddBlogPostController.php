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
		require_once __DIR__ . '../Views/add_blog_article.php';
	}

	public function addBlogPost()
	{
		$title = $_POST['title'];
		$chapo = $_POST['chapo'];
		$content = $_POST['content'];
		$author = $_POST['author'];
		$status = $_POST['status'];

		$this->articleModel->addArticle($title, $chapo, $content, $author, $status);

		header("Location: articles");
		exit();
	}
}
