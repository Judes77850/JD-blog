<?php

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
$twig = new \Twig\Environment($loader);


try {
	echo $twig->render('footer.twig');
} catch (\Twig\Error\LoaderError $e) {
	echo 'Twig Loader Error: ' . $e->getMessage();
} catch (\Twig\Error\RuntimeError $e) {
	echo 'Twig Runtime Error: ' . $e->getMessage();
} catch (\Twig\Error\SyntaxError $e) {
	echo 'Twig Syntax Error: ' . $e->getMessage();
}
