<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'vendor/autoload.php';

use Bramus\Router\Router;

$router = new Router();

$router->get('/', function () {
	require_once 'Views/home.php';
});

$router->get('/articles', function () {
	require_once 'Views/blog_list.php';
});

$router->get('/article', function () {
	// Récupérer l'ID de l'article depuis les paramètres de l'URL
	$articleId = $_GET['id'] ?? null;

	// Vérifier si l'ID de l'article est valide
	if ($articleId) {
		// Utilisez $articleId comme vous le souhaitez dans votre logique de contrôleur
		require_once 'Views/show_article.php';
	} else {
		// Gestion d'erreur si l'ID de l'article est manquant
		echo 'ID d\'article manquant dans l\'URL.';
	}
});


$router->get('/admin_home', function () {
	require_once 'Views/admin/admin_home.php';
});

$router->get('/admin_blog_list', function () {
	require_once 'Views/admin/admin_blog_list.php';
});

$router->get('/logout', function () {
	require_once 'Views/logout.php';
});

$router->get('/login', function () {
	require_once 'Views/login.php';
});

$router->match('POST|GET', '/connexion', function () {
	require_once 'Views/connexion.php';
});

$router->get('/add_blog_article', function () {
	require_once 'Views/add_blog_article.php';
});

$router->get('/create_article', function () {
	require_once 'Views/create_article.php';
});

$router->post('/create_article', function () {
	require_once 'Views/create_article.php';
});

$router->get('/delete_article', function () {
	require_once 'Views/delete_article.php';
});

$router->post('/delete_article', function () {
	require_once 'Views/delete_article.php';
});

$router->get('/edit_single_article', function () {
	$article_id = $_GET['article_id'];
	echo 'Affichage de l\'article avec l\'ID : ' . $article_id;
	require_once 'Views/edit_single_article.php';
});

$router->post('/update_article', function () {
	require_once 'Views/update_article.php';
});

// Exécutez le routeur
$router->run();