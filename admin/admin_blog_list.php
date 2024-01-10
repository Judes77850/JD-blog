<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	// Redirection vers la page de connexion si l'utilisateur n'est pas connecté
	header("Location: login.php");
	exit();
}

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

// Récupérer tous les articles de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM articles WHERE author = ?");
$query->execute([$user_id]);
$articles = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Administration - Gérer les Articles</title>
</head>
<body>
<header>
	<h1>Mon Blog - Administration</h1>
	<nav>
		<ul>
			<li><a href="../index.php">Accueil</a></li>
			<li><a href="admin_home.php">Accueil Administration</a></li>
			<li><a href="../add_blog_post.php">Créer un article</a></li>
			<li><a href="admin_edit_profile.php">Modifier Profil</a></li>
			<!-- Ajoutez d'autres liens de navigation ici selon les besoins -->
		</ul>
	</nav>
	<?php
	if (isset($_SESSION['pseudo'])) {
		echo "Hello, " . $_SESSION['pseudo'];
	} else {
		echo "Hello";
	}
	?>
</header>

<main>
	<section>
		<h2>Gérer les Articles</h2>
		<?php if (count($articles) > 0) : ?>
			<ul>
				<?php foreach ($articles as $article) : ?>
					<li>
						<h3><?= $article['title']; ?></h3>
						<p><?= $article['chapo']; ?></p>
						<form action="delete_article.php" method="post">
							<input type="hidden" name="article_id" value="<?= $article['id']; ?>">
							<input type="submit" value="Supprimer">
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
			<!-- Autres liens du footer -->
		</ul>
	</nav>
</footer>
</body>
</html>
