<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Détail de l'article - Mon Blog</title>
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
				echo'<li><a href="admin/admin_home.php">Mon Compte</a></li>';
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
	<section>
		<?php
		if (isset($_GET['id'])) {
			$article_id = $_GET['id'];

			// Exemple de connexion à la base de données (à adapter)
			$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

			// Exemple de requête pour récupérer les détails de l'article (à adapter)
			$query = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
			$query->execute(array(':id' => $article_id));
			$article = $query->fetch(PDO::FETCH_ASSOC);

			if ($article) {
				echo '<h2>' . $article['title'] . '</h2>';
				echo '<p>' . $article['chapo'] . '</p>';
				echo '<p>' . $article['content'] . '</p>';
				echo '<p>Auteur : ' . $article['author'] . '</p>';
				echo '<p>Date de dernière mise à jour : ' . $article['updated_at'] . '</p>';

				// Formulaire pour ajouter un commentaire
				echo '<form action="add_comment.php" method="post">';
				echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';
				echo '<label for="author">Votre nom :</label><br>';
				echo '<input type="text" id="auteur" name="auteur"><br>';
				echo '<label for="contenu_commentaire">Votre commentaire :</label><br>';
				echo '<textarea id="contenu_commentaire" name="contenu_commentaire"></textarea><br>';
				echo '<input type="submit" value="Ajouter un commentaire">';
				echo '</form>';

			} else {
				echo '<p>Article non trouvé. 4</p>';
			}
		} else {
			echo '<p>Identifiant d\'article non spécifié.</p>';
		}
		?>
	</section>
</main>

<footer>
	<nav>
		<ul>
			<li><a href="admin/admin_home.php">Administration</a></li>
			<!-- Autres liens du footer -->
		</ul>
	</nav>
</footer>
</body>
</html>
