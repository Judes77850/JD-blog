<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Modifier/Supprimer un Article - Mon Blog</title>
</head>
<body>
<header>
	<h1>Mon Blog - Administration</h1>
	<nav>
		<ul>
			<li><a href="admin_home.php">Accueil Administration</a></li>
			<li><a href="admin_blog_list.php">Gérer les Articles</a></li>
			<li><a href="admin_edit_profile.php">Modifier Profil</a></li>
			<!-- Ajoutez d'autres liens de navigation ici selon vos besoins -->
		</ul>
	</nav>
</header>

<main>
	<section>
		<h2>Modifier/Supprimer un Article</h2>
		<?php

		// récup de l'ID de l'article depuis l'URL
		if (isset($_GET['id'])) {
			$article_id = $_GET['id'];

			// connexion bdd
			$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

			// récupérer les détails de l'article
			$query = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
			$query->execute(array(':id' => $article_id));
			$article = $query->fetch(PDO::FETCH_ASSOC);

			// Vérification de l'existence de l'article
			if ($article) {
				// Affichage des détails de l'article avec des options de modification ou suppression
				?>
				<h3>Titre : <?php echo $article['titre']; ?></h3>
				<p>Chapô : <?php echo $article['chapo']; ?></p>
				<p>Contenu : <?php echo $article['contenu']; ?></p>
				<p>Auteur : <?php echo $article['auteur']; ?></p>
				<p>Auteur : <?php echo $article['status']; ?></p>
				<a href="edit_single_article.php?id=<?php echo $article['id']; ?>">Modifier</a>
				<a href="delete_article.php?id=<?php echo $article['id']; ?>">Supprimer</a>
				<?php
			} else {
				echo '<p>Article non trouvé.</p>';
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
			<li><a href="logout.php">Déconnexion</a></li>
		</ul>
	</nav>
</footer>
</body>
</html>
