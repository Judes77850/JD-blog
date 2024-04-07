<?php
// models/AdminBlogModel.php

class AdminBlogModel
{
	public static function getArticlesByUserId($user_id)
	{
		require_once __DIR__ . '/../DatabaseManager.php';
		$pdo = DatabaseManager::getPdoInstance();

		$query = $pdo->prepare("SELECT * FROM articles WHERE author = ? ORDER BY created_at DESC");
		$query->execute([$user_id]);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}

?>
