<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Modifier Profil - Mon Blog</title>
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
			<li><a href="home.php">Accueil</a></li>
			<!-- Ajoutez d'autres liens de navigation ici selon vos besoins -->
		</ul>
	</nav>
</header>

<main>
	<?php
	session_start();
	if (isset($_SESSION['user_id'])) {
		// Connexion à la base de données
		$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

		// Récupérer le prénom de l'utilisateur en utilisant son ID depuis la session
		$user_id = $_SESSION['user_id'];
		$query = $pdo->prepare("SELECT pseudo, lastname, firstname, email FROM user WHERE id = ?");
		$query->execute([$user_id]);
		$user = $query->fetch(PDO::FETCH_ASSOC);

		// Si le prénom est récupéré avec succès, le stocker dans la session
		if ($user && isset($user['firstname, pseudo, lastname, email'])) {
			$_SESSION['firstname'] = $user['firstname'];
			$_SESSION['lastname'] = $user['lastname'];
			$_SESSION['pseudo'] = $user['pseudo'];
			$_SESSION['email'] = $user['email'];
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
	<section>
		<h2>Modifier Profil</h2>
		<!-- Formulaire de modification de profil -->
		<form action="traitement_modification_profil.php" method="post">
			<label for="nom">Nom :</label><br>
			<input type="text" id="nom" name="nom" value="<?php echo isset($_SESSION['lastname']) ? $_SESSION['lastname'] : ''; ?>"><br>
			<label for="prenom">Prénom :</label><br>
			<input type="text" id="prenom" name="prenom" value="<?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : ''; ?>"><br>
            <label for="pseudo">Pseudo :</label><br>
			<input type="text" id="pseudo" name="pseudo" value="<?php echo isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : ''; ?>"><br>
			<label for="email">Adresse e-mail :</label><br>
			<input type="email" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>"><br>
			<label for="password">Nouveau mot de passe :</label><br>
			<input type="password" id="password" name="password"><br>
			<input type="submit" value="Enregistrer les modifications">
		</form>
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
