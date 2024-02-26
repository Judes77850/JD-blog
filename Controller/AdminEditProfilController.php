<?php

namespace Controller;

use Twig\Environment;
require_once __DIR__ . '/../DatabaseManager.php';
require_once 'Views/header.php';

class AdminEditProfilController
{
	private $twig;
	private $userController;

	public function __construct(Environment $twig, UserController $userController)
	{
		$this->twig = $twig;
		$this->userController = $userController;
	}

	public function showEditForm()
	{
		$userData = $this->userController->getUserData();

		$loader = new \Twig\Loader\FilesystemLoader('templates');
		$twig = new \Twig\Environment($loader);
		echo $twig->render('admin_edit_profil.twig', ['user' => $userData]);
	}

	public function updateProfil()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (isset($_POST["user_id"]) && isset($_POST["lastname"]) && isset($_POST["firstname"]) && isset($_POST["pseudo"]) && isset($_POST["email"])) {
				$userId = $_POST["user_id"];
				$lastname = $_POST["lastname"];
				$firstname = $_POST["firstname"];
				$pseudo = $_POST["pseudo"];
				$email = $_POST["email"];
				$newPassword = $_POST["new_password"];

				if (!empty($newPassword)) {
					$newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
				} else {
					$userData = $this->userController->getUserData();
					$newPasswordHashed = $userData['password'];
				}

				try {
					$pdo = \DatabaseManager::getPdoInstance();
					$query = $pdo->prepare("UPDATE user SET lastname = ?, firstname = ?, pseudo = ?, email = ?, password = ? WHERE id = ?");
					$query->execute([$lastname, $firstname, $pseudo, $email, $newPasswordHashed, $userId]);

					session_start();
					$_SESSION['user_pseudo'] = $pseudo;
					$_SESSION['user_lastname'] = $lastname;
					$_SESSION['user_firstname'] = $firstname;
					$_SESSION['user_email'] = $email;

					header("Location: /admin_home");
					exit();
				} catch (PDOException $e) {
					echo "Erreur lors de la mise à jour des données : " . $e->getMessage();
				}
			} else {
				header("Location: error.php");
				exit();
			}
		}
	}

}
