<?php
namespace Model;

class UserModel {
	private $pdo;

	public function __construct($pdo) {
		$this->pdo = $pdo;
	}

	public function getUserById($userId) {
		$query = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
		$query->execute([$userId]);
		return $query->fetch(\PDO::FETCH_ASSOC);
	}

}
