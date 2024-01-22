<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Administration - JD-Blog</title>
</head>
<body>
<header>
	<nav>
            <?php
            $router = require_once __DIR__ . '/../../index.php';
            require_once 'Views/header.php';
            ?>
		<ul>
			<li><a href="/add_blog_article">Créer un article</a></li>
			<li><a href="/admin_blog_list">Gérer mes Articles</a></li>
			<li><a href="admin_edit_profile.php">Modifier Profil</a></li>
		</ul>
	</nav>
</header>
<main>
	<section>
		<h2>Bienvenue dans l'espace d'administration</h2>
		<p>Ici, vous pourrez gérer les articles, modifier votre profil, etc.</p>
	</section>
</main>
<footer>
	<nav>
		<ul>
			<li><a href="logout">Déconnexion</a></li>
		</ul>
	</nav>
</footer>
</body>
</html>
