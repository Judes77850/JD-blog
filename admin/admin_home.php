<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Administration - Mon Blog</title>
</head>
<body>
<header>
	<h1>Mon Blog - Administration</h1>
	<nav>
		<ul>
            <li><a href="../index.php">Accueil</a></li>
			<li><a href="admin_home.php">Accueil Administration</a></li>
			<li><a href="../add_blog_post.php">Créer un article</a></li>
			<li><a href="admin_blog_list.php">Gérer les Articles</a></li>
			<li><a href="admin_edit_profile.php">Modifier Profil</a></li>
			<!-- Ajoutez d'autres liens de navigation ici selon besoins -->
		</ul>
	</nav>
	<?php
    session_start();
	if (!isset($_SESSION['user_id'])) {
		header("Location: ../login.php"); // Rediriger vers la page de connexion
		exit();
	}
	if (isset($_SESSION['user_id'])) {
		// Connexion à la base de données
		$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

		// Récupérer le prénom de l'utilisateur en utilisant son ID depuis la session
		$user_id = $_SESSION['user_id'];
		$query = $pdo->prepare("SELECT pseudo FROM user WHERE id = ?");
		$query->execute([$user_id]);
		$user = $query->fetch(PDO::FETCH_ASSOC);

		// Si le prénom est récupéré avec succès, le stocker dans la session
		if ($user && isset($user['pseudo'])) {
			$_SESSION['pseudo'] = $user['pseudo'];
		}

		// Afficher le prénom de l'utilisateur
		if (isset($_SESSION['pseudo'])) {
			echo "Hello, " . $_SESSION['pseudo'];
		} else {
			echo "Hello";
		}
		// Autres contenus spécifiques à l'utilisateur connecté
		// ...
	}


	?>
</header>

<main>
	<section>
		<h2>Bienvenue dans l'espace d'administration</h2>
		<!-- Contenu spécifique à l'espace d'administration -->
		<p>Ici, vous pourrez gérer les articles, modifier votre profil, etc.</p>
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
