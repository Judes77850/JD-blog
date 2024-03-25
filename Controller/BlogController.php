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
		$articles = $this->articleModel->getPublishedArticles();

		include __DIR__ . '/../templates/blog_list.twig';
	}
}

