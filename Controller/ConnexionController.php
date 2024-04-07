<?php

namespace Controller;
require_once __DIR__ . '/../DatabaseManager.php';

use PDO;

class ConnexionController
{

	public function connexion()
	{

		$loader = new \Twig\Loader\FilesystemLoader('templates');
		$twig = new \Twig\Environment($loader);

		echo $twig->render('login.twig');
	}

	public function login()
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$email = $_POST["email"];
			$password = $_POST["password"];

			$pdo = \DatabaseManager::getPdoInstance();

			$query = $pdo->prepare("SELECT * FROM user WHERE email = ?");
			$query->execute([$email]);
			$user = $query->fetch(PDO::FETCH_ASSOC);

			if ($user && password_verify($password, $user['password'])) {
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['user_role'] = $user['role'];
				$_SESSION['user_email'] = $user['email'];
				$_SESSION['user_firstname'] = $user['firstname'];
				$_SESSION['user_lastname'] = $user['lastname'];
				$_SESSION['user_pseudo'] = $user['pseudo'];
				header("Location: /");
			} else {
				header("Location: register");
			}
			exit();
		}
	}

	public function logout()
	{
		session_start();
		$_SESSION = array();

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

		unset($_SESSION['user_id']);
		session_destroy();

		header("Location: /");
		exit();
	}
}
