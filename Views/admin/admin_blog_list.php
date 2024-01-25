
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Administration - Gérer les Articles</title>
</head>
<body>
<header>
    <nav>
		<?php
		$router = require_once __DIR__ . '/../../index.php';
		require_once 'Views/header.php';
		?>
    </nav>
    <ul class="list-unstyled w-50 mx-auto justify-content-between">

        <li><a href="admin_home.php">Accueil Administration</a></li>
        <li><a href="/add_blog_article">Créer un article</a></li>
        <li><a href="admin_edit_profile.php">Modifier Profil</a></li>
    </ul>
	<?php
	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

// Récupérer tous les articles de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM articles WHERE author = ? order by articles.created_at desc");
$query->execute([$user_id]);
$articles = $query->fetchAll(PDO::FETCH_ASSOC);

?>
</header>

<main>
	<section>
		<h2>Gérer mes Articles</h2>
		<?php if (count($articles) > 0) : ?>
			<ul>
				<?php foreach ($articles as $article) : ?>
					<li>
						<h3><?= $article['title']; ?></h3>
						<p><?= $article['chapo']; ?></p>
						<p><?= $article['status']; ?></p>
						<form action="../delete_article" method="post">
							<input type="hidden" name="article_id" value="<?= $article['id']; ?>">
							<input type="submit" value="Supprimer">
						</form>
                        <form action="/edit_single_article" method="get">
                            <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
                            <input type="submit" value="Modifier">
                        </form>
                    </li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p>Aucun article trouvé.</p>
		<?php endif; ?>
	</section>
</main>

<footer>
	<nav>
		<ul>
			<li><a href="logout.php">Déconnexion</a></li>
		</ul>
	</nav>
</footer>
</body>
</html>
