<?php

require_once __DIR__ . '/../model/AdminBlogModel.php';

class AdminBlogController
{
	public function listArticles()
	{
		if (isset($_SESSION['user_id'])) {
			$user_id = $_SESSION['user_id'];
			$articles = AdminBlogModel::getArticlesByUserId($user_id);

			$loader = new \Twig\Loader\FilesystemLoader('templates');
			$twig = new \Twig\Environment($loader);
			echo $twig->render('admin_blog_list.twig', ['articles' => $articles]);
		} else {

			header('Location: /login');
			exit();
		}
	}

	public function adminDashboard()
	{
		$userRole = $this->getUserRole();

		$loader = new \Twig\Loader\FilesystemLoader('templates');
		$twig = new \Twig\Environment($loader);

		echo $twig->render('admin_home.twig', [
			'userRole' => $userRole
		]);
	}

	private function getUserRole()
	{
		return $_SESSION['user_role'] ?? 'admin';
	}


}
