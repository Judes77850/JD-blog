<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Mon Blog - Liste des Articles</title>
	<!-- Vous pouvez inclure ici vos liens vers des fichiers CSS, des scripts JavaScript, etc. -->
</head>
<body>
<header>
	<h1>Mon Blog</h1>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="blog_list.php">Articles</a></li>
			<?php
			session_start();
			if (isset($_SESSION['user_id'])) {
				echo '<li><a href="logout.php">Déconnexion</a></li>';
			} else {
				echo '<li><a href="login.php">Connexion</a></li>';
				echo '<li><a href="register.php">Créer un compte</a></li>';
			}
			?>
        </ul>
    </nav>
</header>

<main>
	<h2>Liste des Articles</h2>
	<section>
		<?php
		// Ici, vous devrez récupérer les articles depuis la base de données et les afficher
		// Par exemple (à adapter selon votre architecture et votre logique de récupération des articles) :

		// Exemple de connexion à la base de données (à adapter)
		$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

		// Exemple de requête pour récupérer les articles (à adapter)
		$query = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC");
		$articles = $query->fetchAll(PDO::FETCH_ASSOC);

		// Affichage des articles
		foreach ($articles as $article) {
			echo '<article>';
			echo '<h3>' . $article['title'] . '</h3>';
			echo '<p>Date de dernière modification : ' . $article['updated_at'] . '</p>';
			echo '<p>' . $article['chapo'] . '</p>';
			echo '<p>' . $article['author'] . '</p>';
			echo '<a href="blog_detail.php?id=' . $article['id'] . '">Lire l\'article</a>';
			echo '</article>';
		}
		?>
	</section>
</main>

<footer>
	<nav>
		<ul>
            <li><a href="admin/admin_home.php">Mon Compte</a></li>
		</ul>
	</nav>
</footer>
</body>
</html>
