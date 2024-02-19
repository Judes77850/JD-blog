<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../DatabaseManager.php';
require_once 'Views/header.php';
require __DIR__ . '/../Model/Article.php';

$router = require_once __DIR__ . '/../index.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader);

$pdo = DatabaseManager::getPdoInstance();
$articleModel = new \Model\Article($pdo);
$articles = $articleModel->getPublishedArticles();

try {
	$template = $twig->load('blog_list.twig');
	echo $template->render(['articles' => $articles]);
} catch (\Twig\Error\LoaderError $e) {
	echo 'Erreur de chargement du modèle Twig (LoaderError): ' . $e->getMessage();
} catch (\Twig\Error\RuntimeError $e) {
	echo 'Erreur d\'exécution du modèle Twig (RuntimeError): ' . $e->getMessage();
} catch (\Twig\Error\SyntaxError $e) {
	echo 'Erreur de syntaxe dans le modèle Twig (SyntaxError): ' . $e->getMessage();
}
