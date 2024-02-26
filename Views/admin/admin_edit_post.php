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
            <li><a href="admin_edit_profil.php">Modifier Profil</a></li>
        </ul>
    </nav>
</header>

<main>
    <section>
        <h2>Modifier/Supprimer un Article</h2>
		<?php

		if (isset($_GET['id'])) {
			$article_id = $_GET['id'];

			$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

			$query = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
			$query->execute(array(':id' => $article_id));
			$article = $query->fetch(PDO::FETCH_ASSOC);

			if ($article) {
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
				echo '<p>Article non trouvé 1.</p>';
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
