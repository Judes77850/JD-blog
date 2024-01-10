<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Modifier/Supprimer un Article - Mon Blog</title>
	<!-- Vous pouvez inclure ici vos liens vers des fichiers CSS, des scripts JavaScript, etc. -->
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
		// Ici, vous devrez récupérer les détails de l'article à modifier/supprimer depuis la base de données
		// et les afficher pour permettre à l'utilisateur de les modifier ou supprimer

		// Exemple de récupération de l'ID de l'article depuis l'URL
		if (isset($_GET['id'])) {
			$article_id = $_GET['id'];

			// Exemple de connexion à la base de données (à adapter)
			$pdo = new PDO('mysql:host=nom_hote;dbname=nom_base_de_donnees', 'utilisateur', 'mot_de_passe');

			// Exemple de requête pour récupérer les détails de l'article (à adapter)
			$query = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
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
				<a href="edit_article.php?id=<?php echo $article['id']; ?>">Modifier</a>
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
			<!-- Autres liens du footer -->
		</ul>
	</nav>
</footer>
</body>
</html>
