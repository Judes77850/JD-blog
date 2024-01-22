<?php

namespace Model;

class HeaderModel
{
	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function getUserPseudo($userId)
	{
		$query = $this->pdo->prepare("SELECT pseudo FROM user WHERE id = ?");
		$query->execute([$userId]);
		$user = $query->fetch(\PDO::FETCH_ASSOC);

		return ($user && isset($user['pseudo'])) ? $user['pseudo'] : null;
	}
}
