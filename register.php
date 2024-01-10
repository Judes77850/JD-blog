<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Inscription - Mon Blog</title>
	<!-- Vous pouvez inclure ici vos liens vers des fichiers CSS, des scripts JavaScript, etc. -->
</head>
<body>
<header>
	<h1>Mon Blog - Inscription</h1>
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
		<h2>Inscription</h2>
		<!-- Formulaire d'inscription -->
		<form action="traitement_inscription.php" method="post">
			<label for="lastName">Nom :</label><br>
			<input type="text" id="nom" name="nom"><br>
			<label for="firstname">Prénom :</label><br>
			<input type="text" id="prenom" name="prenom"><br>
            <label for="pseudo">Pseudo :</label><br>
			<input type="text" id="pseudo" name="pseudo"><br>
			<label for="email">Adresse e-mail :</label><br>
			<input type="email" id="email" name="email"><br>
			<label for="password">Mot de passe :</label><br>
			<input type="password" id="password" name="password"><br>
			<input type="submit" value="S'inscrire">
		</form>
	</section>
</main>

<footer>
	<!-- Liens de bas de page -->
</footer>
</body>
</html>
