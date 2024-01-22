<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Article - Mon Blog</title>
</head>
<body>
<header>
    <h1>Mon Blog - Ajouter un Article</h1>
    <nav>
        <ul>
            <li><a href="/">Accueil</a></li>
            <li><a href="articles">Articles</a></li>
			<?php
			session_start();
			var_dump($_SESSION);
			if (isset($_SESSION['user_id'])) {
				echo '<li><a href="logout">Déconnexion</a></li>';
			} else {
				echo '<li><a href="login">Connexion</a></li>';
				echo '<li><a href="register.php">Créer un compte</a></li>';
			}
			?>
        </ul>
    </nav>
</header>

<main>
    <section>
        <h2>Ajouter un nouvel article</h2>
        <form action="create_article" method="post" enctype="multipart/form-data">
            <label for="title">Titre :</label><br>
            <input type="text" id="title" name="titre" required><br>

            <label for="chapo">Chapô :</label><br>
            <textarea id="chapo" name="chapo" required></textarea><br>

            <label for="content">Contenu :</label><br>
            <textarea id="content" name="content" required></textarea><br>

            <label for="author">Auteur :</label><br>
            <input type="text" id="author" name="author" value="<?php echo $_SESSION['user_pseudo'] ?? ''; ?>" required><br>

            <label for="image">Image (moins de 2mo) :</label><br>
            <input type="file" id="image" name="image" accept="image/*"><br>

            <label for="status">Status :</label><br>
            <select id="status" name="status" required>
                <option value="published">Publié</option>
                <option value="pending">En attente</option>
            </select><br>
            <input type="hidden" name="route" value="add_blog_article">
            <input type="submit" value="Ajouter l'article">
        </form>
    </section>
</main>

<footer>
    <nav>
        <ul>
            <li><a href="admin/">Administration</a></li>
        </ul>
    </nav>
</footer>
</body>
</html>
