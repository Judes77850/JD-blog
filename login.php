<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Mon Blog</title>
</head>
<body>
<header>
    <h1>Mon Blog - Connexion</h1>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="blog_list.php">Articles</a></li>
            <!-- Ajoutez d'autres liens de navigation ici -->
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
    <section>
        <a href="register.php">
            <button>Créer un compte</button>
        </a>
    </section>
</main>

<footer>
    <!-- Liens de bas de page -->
</footer>
</body>
</html>
