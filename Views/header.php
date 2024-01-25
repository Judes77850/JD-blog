<!-- Vue header.php (Views/header.php) -->
<?php
// Views/header.php

require_once __DIR__ . '/../Model/HeaderModel.php';
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');
$headerModel = new \Model\HeaderModel($pdo);
$userId = $_SESSION['user_id'] ?? null;
$pseudo = $headerModel->getUserPseudo($userId);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JD-Blog</title>
    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<header>
    <h1>JD-Blog</h1>
    <nav>
		<?php
		echo '<p class="ca">Hello, ' . $pseudo . '</p>';
		echo '<ul class="d-flex list-unstyled w-50 mx-auto justify-content-between con">';
		if (isset($_SESSION['user_id'])) {
			echo '<li><a href="/">Accueil</a></li>';
			echo '<li><a href="articles">Articles</a></li>';
			echo '<li><a href="admin_home">Mon Compte</a></li>';
			echo '<li><a href="logout">Déconnexion</a></li>';
		} else {
			echo '<p>Hello</p>';
			echo '<li><a href="login">Connexion</a></li>';
			echo '<li><a href="register.php">Créer un compte</a></li>';
		}
		echo '</ul>';
		?>
    </nav>
</header>

