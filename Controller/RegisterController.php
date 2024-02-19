<?php

namespace Controller;

use Twig\Environment;
use PDO;

class RegisterController
{
	private $twig;
	private $pdo;

	public function __construct(Environment $twig, PDO $pdo)
	{
		$this->twig = $twig;
		$this->pdo = $pdo;
	}

	public function showRegisterForm()
	{
		$content = $this->twig->render('register.twig');
		echo $content;
	}

	public function registerUser()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$firstname = $_POST["prenom"];
			$lastname = $_POST["nom"];
			$pseudo = $_POST["pseudo"];
			$email = $_POST["email"];
			$password = $_POST["password"];

			$password_hashed = password_hash($password, PASSWORD_DEFAULT);

			$query = $this->pdo->prepare("INSERT INTO user (firstname, lastname, pseudo, email, password) VALUES (?, ?, ?, ?, ?)");

			$success = $query->execute([$firstname, $lastname, $pseudo, $email, $password_hashed]);

			if ($success) {
				echo "Inscription réussie pour l'utilisateur : " . $pseudo;
				echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 2000);</script>";
			} else {
				echo "Une erreur est survenue lors de l'inscription.";
			}
		}
	}
}
