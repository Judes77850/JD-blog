<?php
// Démarrez la session
session_start();

// Détruisez toutes les données de la session
$_SESSION = array();

// Si vous utilisez des cookies de session, détruisez également le cookie de session
if (ini_get("session.use_cookies")) {
	$params = session_get_cookie_params();
	setcookie(
		session_name(),
		'',
		time() - 42000,
		$params["path"],
		$params["domain"],
		$params["secure"],
		$params["httponly"]
	);
}

// Détruisez la session
session_destroy();

// Redirigez vers une autre page après la déconnexion (par exemple, la page d'accueil)
header("Location: index.php");
exit;

