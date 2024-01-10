<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Connexion - Mon Blog</title>
	<!-- Vous pouvez inclure ici vos liens vers des fichiers CSS, des scripts JavaScript, etc. -->
</head>
<body>
<header>
	<h1>Mon Blog - Connexion</h1>
	<nav>
		<ul>
			<li><a href="index.php">Accueil</a></li>
			<li><a href="blog_list.php">Articles</a></li>
			<!-- Ajoutez d'autres liens de navigation ici selon vos besoins -->
		</ul>
	</nav>
</header>

<main>
	<section>
		<h2>Connexion</h2>
		<!-- Formulaire de connexion -->
		<form action="connexion.php" method="post">
			<label for="email">Adresse e-mail :</label><br>
			<input type="email" id="email" name="email"><br>
			<label for="password">Mot de passe :</label><br>
			<input type="password" id="password" name="password"><br>
			<input type="submit" value="Se connecter">
		</form>
	</section>
</main>

<footer>
	<!-- Liens de bas de page -->
</footer>
</body>
</html>
