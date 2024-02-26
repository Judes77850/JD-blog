<?php

require_once 'vendor/autoload.php';
require_once 'Controller/AdminEditProfilController.php';

use Controller\AdminEditProfilController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$requestMethod = $_SERVER['REQUEST_METHOD'];

// Configuration de Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

// Instanciation du contrôleur avec l'objet $twig en argument
$controller = new AdminEditProfilController($twig);

if ($requestMethod === 'GET') {
	$controller->showEditForm();
}

if ($requestMethod === 'POST') {
	$controller->updateProfil($_POST);
}
