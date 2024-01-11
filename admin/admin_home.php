<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Administration - JD-Blog</title>
</head>
<body>
<header>
	<h1>JD-Blog - Administration</h1>
	<nav>
		<ul>
            <li><a href="../index.php">Accueil</a></li>
			<li><a href="../add_blog_post.php">Créer un article</a></li>
			<li><a href="admin_blog_list.php">Gérer mes Articles</a></li>
			<li><a href="admin_edit_profile.php">Modifier Profil</a></li>
			<!-- Ajoutez d'autres liens de navigation ici selon besoins -->
		</ul>
	</nav>
	<?php
    session_start();
	if (!isset($_SESSION['user_id'])) {
		header("Location: ../login.php"); // Redirige vers la page de connexion
		exit();
	}
	if (isset($_SESSION['user_id'])) {
		// Connexion bdd
		$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

		// Récupére le pseudo de l'utilisateur en utilisant son ID depuis session
		$user_id = $_SESSION['user_id'];
		$query = $pdo->prepare("SELECT pseudo FROM user WHERE id = ?");
		$query->execute([$user_id]);
		$user = $query->fetch(PDO::FETCH_ASSOC);

		// Si pseudo est récupéré, le stocker dans la session
		if ($user && isset($user['pseudo'])) {
			$_SESSION['pseudo'] = $user['pseudo'];
		}

		// Afficher le pseudo de l'utilisateur
		if (isset($_SESSION['pseudo'])) {
			echo "Hello, " . $_SESSION['pseudo'];
		} else {
			echo "Hello";
		}
	}


	?>
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
			<li><a href="../logout.php">Déconnexion</a></li>
		</ul>
	</nav>
</footer>
</body>
</html>
