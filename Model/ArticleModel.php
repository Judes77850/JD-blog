<?php

namespace Model;

class ArticleModel
{
	private $pdo;

	public function __construct($pdo)
	{
		$this->pdo = $pdo;
	}

	public function getArticleById($articleId)
	{
		$query = "
            SELECT articles.*, user.firstname, user.lastname
            FROM articles
            LEFT JOIN user ON articles.author = user.id
            WHERE articles.id = :id
        ";

		$statement = $this->pdo->prepare($query);
		$statement->bindParam(':id', $articleId, \PDO::PARAM_INT);
		$statement->execute();

		$result = $statement->fetch(\PDO::FETCH_ASSOC);
		return $result;
	}
}

