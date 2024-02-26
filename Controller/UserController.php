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
		$pdo = \DatabaseManager::getPdoInstance(); // Utilisez le nom de classe complet avec un antislash pour éviter les erreurs
		$userId = $_SESSION['user_id'];
		$query = $pdo->prepare("SELECT * FROM user WHERE id = ?");
		$query->execute([$userId]);
		$userData = $query->fetch(PDO::FETCH_ASSOC);

		return $userData;
	}
}
