<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Article - Mon Blog</title>
    <!-- Vous pouvez inclure ici vos liens vers des fichiers CSS, des scripts JavaScript, etc. -->
</head>
<body>
<header>
    <h1>Mon Blog - Modifier un Article</h1>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="blog_list.php">Articles</a></li>
            <li><a href="login.php">Connexion</a></li>
            <!-- Ajoutez d'autres liens de navigation ici selon vos besoins -->
        </ul>
    </nav>
</header>

<main>
    <section>
        <h2>Modifier l'article</h2>
		<?php
		// Ici, vous devrez récupérer les détails de l'article à modifier depuis la base de données
		// et les pré-remplir dans le formulaire de modification

		// Vérification de la présence de l'ID de l'article dans l'URL
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
				// Affichage du formulaire pré-rempli avec les détails de l'article
				?>
                <form action="traitement_modification_article.php" method="post">
                    <input type="hidden" name="article_id" value="<?php echo $article['id']; ?>">
                    <label for="titre">Titre :</label><br>
                    <input type="text" id="titre" name="titre" value="<?php echo $article['titre']; ?>"><br>
                    <label for="chapo">Chapô :</label><br>
                    <textarea id="chapo" name="chapo"><?php echo $article['chapo']; ?></textarea><br>
                    <label for="contenu">Contenu :</label><br>
                    <textarea id="contenu" name="contenu"><?php echo $article['contenu']; ?></textarea><br>
                    <label for="auteur">Auteur :</label><br>
                    <input type="text" id="auteur" name="auteur" value="<?php echo $article['auteur']; ?>"><br>
                    <input type="submit" value="Enregistrer les modifications">
                </form>
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
            <li><a href="admin/">Administration</a></li>
            <!-- Autres liens du footer -->
        </ul>
    </nav>
</footer>
</body>
</html>
