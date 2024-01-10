<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Ajouter un Article - Mon Blog</title>
	<!-- Vous pouvez inclure ici vos liens vers des fichiers CSS, des scripts JavaScript, etc. -->
</head>
<body>
<header>
	<h1>Mon Blog - Ajouter un Article</h1>
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
    <section>
        <h2>Ajouter un nouvel article</h2>
        <!-- Formulaire pour ajouter un article -->
        <form action="create_article.php" method="post">
            <label for="titre">Titre :</label><br>
            <input type="text" id="titre" name="titre" required><br>

            <label for="chapo">Chapô :</label><br>
            <textarea id="chapo" name="chapo" required></textarea><br>

            <label for="contenu">Contenu :</label><br>
            <textarea id="contenu" name="contenu" required></textarea><br>

            <label for="auteur">Auteur :</label><br>
            <input type="text" id="auteur" name="auteur" value="<?php echo isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : ''; ?>" required><br>

            <label for="status">Status :</label><br>
            <select id="status" name="status" required>
                <option value="published">Publié</option>
                <option value="pending">En attente</option>
            </select><br>

            <input type="submit" value="Ajouter l'article">
        </form>
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
