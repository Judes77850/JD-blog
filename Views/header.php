<!-- Vue header.php (Views/header.php) -->
<?php
// Views/header.php

require_once __DIR__ . '/../Model/HeaderModel.php'; // Utilisation de __DIR__ pour obtenir le chemin absolu
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');
$headerModel = new \Model\HeaderModel($pdo);
$userId = $_SESSION['user_id'] ?? null;
$pseudo = $headerModel->getUserPseudo($userId);


?>
<header>
    <h1>JD-Blog</h1>
    <nav>
        <ul>
			<?php
			if (isset($_SESSION['user_id'])) {
				print_r($_SESSION);
				echo '<p>Hello, ' . $pseudo . '</p>';
				echo '<li><a href="/">Accueil</a></li>';
            echo '<li><a href="articles">Articles</a></li>';
				echo '<li><a href="admin_home">Mon Compte</a></li>';
				echo '<li><a href="logout">Déconnexion</a></li>';
			} else {
				echo '<p>Hello</p>';
				echo '<li><a href="login">Connexion</a></li>';
				echo '<li><a href="register.php">Créer un compte</a></li>';
			}
			?>
        </ul>
    </nav>
</header>

