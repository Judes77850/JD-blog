<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'DatabaseManager.php';
require_once 'vendor/autoload.php';
require_once 'Controller/ShowArticleController.php';
require_once 'Controller/CommentController.php';
require_once 'Controller/ContactController.php';
require_once 'Controller/RegisterController.php';


use Bramus\Router\Router;
use Controller\ContactController;
use Controller\RegisterController;

$pdo = DatabaseManager::getPdoInstance();
$router = new Router();
$controller = new ShowArticleController();
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$registerController = new RegisterController($twig, $pdo);

$router->get('/register', function () use ($registerController) {
	$registerController->showRegisterForm();
});

$router->post('/register', function () use ($registerController) {
	$registerController->registerUser();
});

$router->get('/contact', function () use ($twig) {
	$contactController = new ContactController($twig);
	$contactController->showContactForm();
});

$router->post('/send_email', function () use ($twig){
	$contactController = new ContactController($twig);
	$contactController->sendEmail();
});

$router->get('/', function () {
	require_once 'Views/home.php';
});

$router->get('/articles', function () {
	require_once 'Views/blog_list.php';
});

$router->get('/article', function () use ($controller) {
	$articleId = $_GET['id'] ?? null;
	$controller->showArticle($articleId);
});

$router->post('/submit_comment', function () {
	$commentController = new CommentController();
	$articleId = $_POST["article_id"] ?? null;
	$commentController->submitComment($articleId);
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

$router->post('/delete_comment', function () {
	$commentController = new CommentController();
	$commentController->deleteComment();
});

$router->run();