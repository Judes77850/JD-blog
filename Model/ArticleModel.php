<?php
// Model/ArticleModel.php
namespace Model;

class ArticleModel {
	private $pdo;

	public function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}

	public function createArticle($title, $chapo, $content, $author, $status) {
		// Logique pour créer un nouvel article dans la base de données
		// ...
	}
}
