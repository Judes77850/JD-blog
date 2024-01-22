<?php
// Modèle Article (Model/Article.php)

namespace Model;

class Article
{
	private $pdo;

	public function __construct(\PDO $pdo)
	{
		try {
			$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->pdo = $pdo;
		} catch (\PDOException $e) {
			// En cas d'erreur, affichez le message d'erreur
			die('Erreur de connexion : ' . $e->getMessage());
		}
	}

	public function getPublishedArticles()
	{
		$query = $this->pdo->query("SELECT a.title, a.content, a.id, a.created_at, a.updated_at, a.chapo, a.image_path, u.firstname, u.lastname 
                           FROM articles a 
                           INNER JOIN user u ON a.author = u.id 
                           WHERE a.status = 'published' 
                           ORDER BY a.created_at DESC");

		return $query->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getArticleById($id)
	{
		$stmt = $this->pdo->prepare("SELECT a.title, a.content, a.id, a.created_at, a.updated_at, a.chapo, a.image_path, u.firstname, u.lastname 
                           FROM articles a 
                           INNER JOIN user u ON a.author = u.id 
                           WHERE a.id = :id");

		$stmt->bindParam(':id', $id);
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}
}