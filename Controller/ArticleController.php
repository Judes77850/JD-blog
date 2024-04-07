<?php

namespace Controller;
require_once __DIR__ . '/../DatabaseManager.php';
require_once __DIR__ . '/../Controller/CommentController.php';
require_once __DIR__ . '/../Model/ArticleModel.php';

use CommentController;
use DatabaseManager;
use PDO;

class ArticleController
{
	private $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function editArticle($id)
	{
		$loader = new \Twig\Loader\FilesystemLoader('templates');
		$twig = new \Twig\Environment($loader);
		$query = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
		$query->execute([$id]);
		$article = $query->fetch(PDO::FETCH_ASSOC);
		if (!$article) {
			return header("Location: ../echec");
		}

		echo $twig->render('edit_single_article.twig', ['article' => $article]);
	}

	public function updateArticle()
	{
		session_start();

		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
			$article_id = $_POST["article_id"];
			$title = $_POST["title"];
			$content = $_POST["content"];
			$status = $_POST["status"];

			try {
				if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
					$image = $_FILES["image"];
					$uploadDirectory = 'assets/images/uploads/';
					$uploadedFileName = $image['name'];
					$targetFilePath = $uploadDirectory . $uploadedFileName;

					if (move_uploaded_file($image["tmp_name"], $targetFilePath)) {
						$image_path = $targetFilePath;
					} else {
						echo "Erreur lors du téléchargement de l'image.";
						return;
					}
				} else {
					$query = $this->pdo->prepare("SELECT image_path FROM articles WHERE id = ?");
					$query->execute([$article_id]);
					$oldImagePath = $query->fetchColumn();
					$image_path = $oldImagePath;
				}

				$query = $this->pdo->prepare("UPDATE articles SET title = ?, content = ?, image_path = ?, status = ? WHERE id = ?");
				$query->execute([$title, $content, $image_path, $status, $article_id]);

				header("Location: /admin_blog_list");
				exit();
			} catch (PDOException $e) {
				echo "Erreur lors de la mise à jour de l'article : " . $e->getMessage();
			}
		} else {
			header("Location: erreur.php");
			exit();
		}
	}

	public function createArticle()
	{
		session_start();

		if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
			$title = $_POST["titre"];
			$chapo = $_POST["chapo"];
			$content = $_POST["content"];
			$status = $_POST["status"];
			$pseudo = $_SESSION['user_pseudo'];
			$authorId = $_SESSION['user_id'];

			try {
				$pdo = DatabaseManager::getPdoInstance();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				echo "Erreur de connexion à la base de données : " . $e->getMessage();
				exit();
			}

			$createdAt = date("Y-m-d H:i:s");

			$userQuery = $pdo->prepare("SELECT id FROM user WHERE pseudo = ?");

			$userQuery->execute([$pseudo]);
			$user = $userQuery->fetch(PDO::FETCH_ASSOC);

			if ($user && isset($user['id'])) {

				$uploadDirectory = 'assets/images/uploads/';
				$uploadedFileName = $_FILES['image']['name'];
				$targetFilePath = $uploadDirectory . $uploadedFileName;

				if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
					try {
						$relativeImagePath = $uploadDirectory . $uploadedFileName;

						$query = $pdo->prepare("INSERT INTO articles (title, chapo, content, status, author, image_path, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
						$query->execute([$title, $chapo, $content, $status, $authorId, $relativeImagePath, $createdAt]);

						header("Location: admin_home");
						exit();
					} catch (PDOException $e) {
						echo "Une erreur est survenue lors de l'ajout de l'article : " . $e->getMessage();
					}
				} else {
					echo "Erreur lors du téléchargement de l'image, l'image doit faire moins de 2mo";
					echo '<a href=/>Accueil</a>';
				}
			} else {
				echo "Auteur non trouvé";
			}
		} else {
			header("Location: erreur.php");
			exit();
		}
	}

	public function deleteArticle()
	{
		session_start();

		if (!isset($_SESSION['user_id'])) {
			header("Location: login");
			exit();
		}

		if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['article_id'])) {
			$article_id = $_POST['article_id'];
			$pdo = DatabaseManager::getPdoInstance();
			$query = $pdo->prepare("DELETE FROM articles WHERE id = ? AND author = ?");
			$query->execute([$article_id, $_SESSION['user_id']]);

			header("Location: admin_blog_list");
		} else {
			header("Location: erreur.php");
		}
		exit();
	}

	public function showArticle($articleId)
	{

		try {
			$queryArticle = $this->pdo->prepare("SELECT * FROM articles WHERE id = ?");
			$queryArticle->execute([$articleId]);
			$article = $queryArticle->fetch(PDO::FETCH_ASSOC);

			if (!$article) {
				echo '<p>Article non trouvé.</p>';
				return;
			}

			$queryAuthor = $this->pdo->prepare("SELECT pseudo FROM user WHERE id = ?");
			$queryAuthor->execute([$article['author']]);
			$user = $queryAuthor->fetch(PDO::FETCH_ASSOC);
			$connectedUser = (isset($_SESSION['user_id']));

			$loader = new \Twig\Loader\FilesystemLoader('templates');
			$twig = new \Twig\Environment($loader);

			echo $twig->render('article.twig', ['article' => $article, 'authorPseudo' => $user['pseudo'], 'connectedUser' => $connectedUser]);
		} catch (PDOException $e) {
			echo "Une erreur est survenue lors du chargement de l'article : " . $e->getMessage();
		}

	}

	public function showArticlesList()
	{

		require_once __DIR__ . '/../vendor/autoload.php';
		require_once __DIR__ . '/../DatabaseManager.php';
		require_once 'Views/header.php';
		require __DIR__ . '/../Model/Article.php';

		$router = require_once __DIR__ . '/../index.php';
		$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
		$twig = new \Twig\Environment($loader);

		$pdo = DatabaseManager::getPdoInstance();
		$articleModel = new \Model\Article($pdo);
		$articles = $articleModel->getPublishedArticles();

		try {
			$template = $twig->load('blog_list.twig');
			echo $template->render(['articles' => $articles]);
		} catch (\Twig\Error\LoaderError $e) {
			echo 'Erreur de chargement du modèle Twig (LoaderError): ' . $e->getMessage();
		} catch (\Twig\Error\RuntimeError $e) {
			echo 'Erreur d\'exécution du modèle Twig (RuntimeError): ' . $e->getMessage();
		} catch (\Twig\Error\SyntaxError $e) {
			echo 'Erreur de syntaxe dans le modèle Twig (SyntaxError): ' . $e->getMessage();
		}
	}
}
