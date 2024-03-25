<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Model/HeaderModel.php';
require_once __DIR__ . '/../DatabaseManager.php';
session_start();


$pdo = DatabaseManager::getPdoInstance();
$headerModel = new \Model\HeaderModel($pdo);
$userId = $_SESSION['user_id'] ?? null;
$pseudo = $headerModel->getUserPseudo($userId);

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader);

try {
	echo $twig->render('header.twig', ['pseudo' => $pseudo, 'user_id' => $userId]);
} catch (\Twig\Error\LoaderError $e) {
	echo 'Twig Loader Error: ' . $e->getMessage();
} catch (\Twig\Error\RuntimeError $e) {
	echo 'Twig Runtime Error: ' . $e->getMessage();
} catch (\Twig\Error\SyntaxError $e) {
	echo 'Twig Syntax Error: ' . $e->getMessage();
}
