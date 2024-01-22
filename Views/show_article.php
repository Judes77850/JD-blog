<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>JD-Blog - Accueil</title>
</head>
<body>
<header>
    <nav>
		<?php
		$router = require_once __DIR__ . '/../index.php';
		require_once 'Views/header.php';
		?>
    </nav>
</header>

<main>
    <section>
		<?php
		$articleId = $_GET['id'] ?? null;

		if ($articleId) {
			$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');
			require __DIR__ . '/../Model/Article.php';
			$articleModel = new \Model\Article($pdo);

			$article = $articleModel->getArticleById($articleId);

			if ($article) {
				echo '<h2>' . $article['title'] . '</h2>';
				echo '<p>' . $article['content'] . '</p>';
				echo '<p>Auteur: ' . $article['firstname'] . ' ' . $article['lastname'] . '</p>';
				echo '<p>le: ' . $article['created_at'] . '</p>';
				echo '<p>path: ' . $article['image_path'] . '</p>';

				if (!empty($article['image_path'])) {
					$relativeImagePath = str_replace(__DIR__, '', $article['image_path']);

					echo '<img src="' . $relativeImagePath . '" alt="Image de l\'article">';
				} else {
					echo '<p>Aucune image disponible.</p>';
				}
			} else {
				echo '<p>Article non trouvé.</p>';
			}
		} else {
			echo '<p>ID d\'article manquant dans l\'URL.</p>';
		}
		?>

        <div>
            <a href="https://github.com/Judes77850" target="_blank">GitHub</a>
            <a href="https://www.linkedin.com/in/julien-desaindes/" target="_blank">LinkedIn</a>
        </div>
    </section>
</main>

<footer>
    <nav>
        <ul>

        </ul>
    </nav>
</footer>
</body>
</html>
