<?php

namespace Model;

class CommentModel
{
	private $pdo;

	public function __construct(\PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function getCommentsByArticleId($articleId)
	{
		$stmt = $this->pdo->prepare("SELECT comment.*, user.pseudo AS author FROM comment 
                                     INNER JOIN user ON comment.author = user.id
                                     WHERE comment.post_id = :articleId 
                                     ORDER BY comment.created_at DESC");
		$stmt->bindParam(':articleId', $articleId, \PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function addComment($articleId, $content)
	{
	}

	public function saveComment($postId, $content, $userId)
	{
		$stmt = $this->pdo->prepare("INSERT INTO comment (post_id, content, author, created_at) VALUES (:postId, :content, :userId, NOW())");

		$stmt->bindParam(':postId', $postId);
		$stmt->bindParam(':content', $content);
		$stmt->bindParam(':userId', $userId);

		$success = $stmt->execute();

		return $success;
	}

	public function deleteComment($commentId) {
		$stmt = $this->pdo->prepare("DELETE FROM comment WHERE id = :commentId");
		$stmt->bindParam(':commentId', $commentId, \PDO::PARAM_INT);

		$success = $stmt->execute();

		return $success;
	}



}

