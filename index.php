<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'DatabaseManager.php';
require_once 'vendor/autoload.php';
require_once 'Controller/CommentController.php';
require_once 'Controller/ContactController.php';
require_once 'Controller/RegisterController.php';
require_once 'Controller/AdminEditProfilController.php';
require_once 'Controller/UserController.php';
require_once 'Controller/ArticleController.php';
require_once 'Controller/HomeController.php';
require_once 'Controller/ConnexionController.php';
require_once 'Controller/AdminBLogController.php';


use Bramus\Router\Router;
use Controller\ContactController;
use Controller\RegisterController;
use Controller\AdminEditProfilController;
use Controller\UserController;
use Twig\Environment;
use Controller\ArticleController;
use Controller\HomeController;
use Controller\ConnexionController;

$pdo = DatabaseManager::getPdoInstance();
$router = new Router();
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
$registerController = new RegisterController($twig, $pdo);
$userController = new UserController($pdo);
$adminEditProfilController = new AdminEditProfilController($twig, $userController);
$articleController = new ArticleController($pdo);
$commentController = new CommentController($pdo);
$connexionController = new ConnexionController($pdo);
$adminBlogController = new AdminBLogController($pdo);

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
	$homeController = new HomeController();
	$homeController->showHome();
});

$router->get('/articles', function () use ($articleController){
	$articleController->showArticlesList();
});

$router->get('/admin_edit_profil', function () use ($adminEditProfilController) {
	$adminEditProfilController->showEditForm();
});

$router->post('/admin_edit_profil', function () use ($adminEditProfilController) {
	$adminEditProfilController->updateProfil($_POST);
});

$router->get('/edit_article/{id}', function ($id) use ($articleController) {
	$articleController->editArticle($id);
});

$router->post('/update_profil', function () use ($adminEditProfilController) {
	$adminEditProfilController->updateProfil();
});

$router->get('/article', function () use ($articleController, $commentController) {
	$articleId = $_GET['id'] ?? null;
	$articleController->showArticle($articleId);
	$commentController->showComments($articleId);
});

$router->get('/create_article', function () use ($articleController) {
	$articleController->createArticle();
});

$router->post('/create_article', function () use ($articleController) {
	$articleController->createArticle();
});

$router->post('/delete_article', function () use ($articleController) {
	$articleController->deleteArticle();
});

$router->get('/admin_home', function () use ($adminBlogController){
	$adminBlogController->adminDashboard();
});

$router->get('/admin_blog_list', function () use ($adminBlogController){
	$adminBlogController->listArticles();
});


$router->match('POST', '/login', function () {
	$connexionController = new ConnexionController();
	$connexionController->login();
});

$router->get('/logout', function () {
	$connexionController = new ConnexionController();
	$connexionController->logout();
});

$router->get('/connexion', function ()  {
	$connexionController = new ConnexionController();
	$connexionController->connexion();
});

$router->post('/connexion', function () use ($connexionController) {
	$connexionController->login();
});


$router->get('/add_article', function () {
	require_once 'templates/add_article.twig';
});


$router->post('/submit_comment', function () {
	$commentController = new CommentController();
	$articleId = $_POST["article_id"] ?? null;
	$commentController->submitComment($articleId);
});

$router->post('/delete_comment', function () {
	$commentController = new CommentController();
	$articleId = $_POST["article_id"] ?? null;
	$commentId = $_POST["comment_id"] ?? null;
	$commentController->deleteComment($articleId, $commentId);
});

$router->post('/update_article', function () use ($articleController) {
	$articleController->updateArticle();
});


$router->get('/users', function () use ($userController) {
	$users = $userController->showUsers();
});

$router->get('/edit_user/{id}', function ($id) use ($userController) {
	$user = $userController->editUser($id);
});

$router->post('/update_user/{id}', function ($id) use ($userController) {
	$userController->updateUser($id);
});

$router->get('/delete_user/{id}', function ($id) use ($userController) {
	$userController->deleteUser($id);
});

$router->get('/echec', function () {
	require_once 'templates/page_echec.twig';
});

$router->set404(function () {
	header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
	require_once 'templates/page_echec.twig';
});


$router->run();