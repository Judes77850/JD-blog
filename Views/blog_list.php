<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Blog - Liste des Articles</title>

</head>
<body>
<nav>
    <?php
    $router = require_once __DIR__ . '/../index.php';
    require_once 'Views/header.php';
    ?>
</nav>
<main>
    <h2>Liste des Articles</h2>
    <section>

		<?php
		$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');
		require __DIR__ . '/../Model/Article.php';
		$articleModel = new \Model\Article($pdo);
		$articles = $articleModel->getPublishedArticles();

        if (isset($articles) && is_array($articles)) {
			foreach ($articles as $article) {
				echo '<article>';
				echo '<h3>' . $article['title'] . '</h3>';
				echo '<p>' . $article['content'] . '</p>';
				echo '<p>Auteur: ' . $article['firstname'] . ' ' . $article['lastname'] . '</p>';
				echo '<p>le: ' . $article['created_at'] . '</p>';
				echo '</article>';
				echo '<a href="/article?id=' . $article['id'] . '">Lire l\'article</a>';
			}
		} else {
			echo '<p>Aucun article trouvé.</p>';
		} ?>
    </section>
</main>

<!-- ... (pied de page) ... -->
</body>
</html>
