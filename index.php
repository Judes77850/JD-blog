<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Mon Blog - Accueil</title>
	<!-- Vous pouvez inclure ici vos liens vers des fichiers CSS, des scripts JavaScript, etc. -->
</head>
<body>
<header>
	<h1>Mon Blog</h1>
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
    <?php
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
		<h2>Super BLOG</h2>
		<p>Une photo et/ou un logo</p>
		<p>Bienvenu sur mon blog</p>

		<h3>Formulaire de contact</h3>
		<form action="traitement_formulaire_contact.php" method="post">
			<label for="nom_prenom">Nom/Prénom :</label><br>
			<input type="text" id="nom_prenom" name="nom_prenom"><br>
			<label for="email">E-mail :</label><br>
			<input type="email" id="email" name="email"><br>
			<label for="message">Message :</label><br>
			<textarea id="message" name="message"></textarea><br>
			<input type="submit" value="Envoyer">
		</form>

		<a href="votre_cv.pdf">Télécharger CV</a>

		<div>
			<a href="https://github.com/Judes77850" target="_blank">GitHub</a>
			<a href="https://www.linkedin.com/in/julien-desaindes/" target="_blank">LinkedIn</a>
		</div>
	</section>
</main>

<footer>
	<nav>
		<ul>
			<!-- Lien vers l'administration -->
			<li><a href="admin/admin_home.php">Mon Compte</a></li>
			<!-- Autres liens du footer -->
		</ul>
	</nav>
</footer>
</body>
</html>
