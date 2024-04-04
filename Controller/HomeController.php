<?php

namespace Controller;

require_once __DIR__ . '/../DatabaseManager.php';
use PDO;

class HomeController
{
	public function showHome()
	{
		$pdo = \DatabaseManager::getPdoInstance();
		$query = $pdo->query("SELECT articles.*, user.pseudo AS author_pseudo FROM articles INNER JOIN user ON articles.author = user.id WHERE articles.status = 'Published' ORDER BY articles.created_at DESC LIMIT 4");
		$articles = $query->fetchAll(PDO::FETCH_ASSOC);
		$loader = new \Twig\Loader\FilesystemLoader('templates');
		$twig = new \Twig\Environment($loader);
		$template = $twig->load('home.twig');
		echo $template->render(['articles' => $articles]);
	}
}
