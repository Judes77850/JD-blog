<?php
namespace Controller;

use PDO;

require_once __DIR__ . '/../DatabaseManager.php';

class UserController {
	private $userModel;

	public function __construct($userModel) {
		$this->userModel = $userModel;
	}

	public function getUserData()
	{
		$pdo = \DatabaseManager::getPdoInstance();
		$userId = $_SESSION['user_id'];
		$query = $pdo->prepare("SELECT * FROM user WHERE id = ?");
		$query->execute([$userId]);
		$userData = $query->fetch(PDO::FETCH_ASSOC);

		return $userData;
	}

	public function showUsers()
	{
		$pdo = \DatabaseManager::getPdoInstance();
		$stmt = $pdo->query("SELECT * FROM user");
		$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$loader = new \Twig\Loader\FilesystemLoader('templates');
		$twig = new \Twig\Environment($loader);
		$template = $twig->load('users.twig');
		echo $template->render(['users' => $users]);
	}

	public function editUser($userId)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$pseudo = $_POST['pseudo'];
			$role = $_POST['role'];
			$email = $_POST['email'];
			$pdo = \DatabaseManager::getPdoInstance();
			$stmt = $pdo->prepare("UPDATE user SET firstname = :firstname, lastname = :lastname, pseudo = :pseudo, role = :role, email = :email WHERE id = :id");
			$stmt->bindParam(':firstname', $firstname);
			$stmt->bindParam(':lastname', $lastname);
			$stmt->bindParam(':pseudo', $pseudo);
			$stmt->bindParam(':role', $role);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':id', $userId);
			$stmt->execute();
			header("Location: /users");
			exit();
		} else {
			$pdo = \DatabaseManager::getPdoInstance();
			$stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
			$stmt->bindParam(':id', $userId);
			$stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			$loader = new \Twig\Loader\FilesystemLoader('templates');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('edit_user.twig');
			echo $template->render(['user' => $user]);
		}

	}

	public function updateUser($userId)
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$pseudo = $_POST['pseudo'];
			$role = $_POST['role'];
			$email = $_POST['email'];
			$pdo = \DatabaseManager::getPdoInstance();
			$stmt = $pdo->prepare("UPDATE user SET firstname = :firstname, lastname = :lastname, pseudo = :pseudo, role = :role, email = :email WHERE id = :id");
			$stmt->bindParam(':firstname', $firstname);
			$stmt->bindParam(':lastname', $lastname);
			$stmt->bindParam(':pseudo', $pseudo);
			$stmt->bindParam(':role', $role);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':id', $userId);
			$stmt->execute();
			header("Location: /users");
			exit();
		}
	}


	public function deleteUser($userId)
	{
		$pdo = \DatabaseManager::getPdoInstance();
		$stmtArticles = $pdo->prepare("DELETE FROM articles WHERE author = :userId");
		$stmtArticles->bindParam(':userId', $userId);
		$stmtArticles->execute();

		$stmtUser = $pdo->prepare("DELETE FROM user WHERE id = :id");
		$stmtUser->bindParam(':id', $userId);
		$stmtUser->execute();
		header("Location: /users");
		exit();
	}
}
