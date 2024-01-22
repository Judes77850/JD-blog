<?php
session_start();

if (!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit();
}

if (!isset($_GET['article_id'])) {
	header("Location: edit_single_article.php");
	exit();
}

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

// Récupérer l'ID de l'article à éditer
$article_id = $_GET['article_id'];
$user_id = $_SESSION['user_id'];

// Vérification si l'article appartient à l'utilisateur connecté
$query = $pdo->prepare("SELECT * FROM articles WHERE id = ? AND author = ?");
$query->execute([$article_id, $user_id]);
$article = $query->fetch(PDO::FETCH_ASSOC);

if (!$article) {
	// Redirection si l'article n'appartient pas à l'utilisateur connecté
	header("Location: edit_single_article.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'Article</title>
</head>
<body>
<header>
    <h1>Modifier l'Article</h1>
</header>

<main>
    <section>
        <h2>Formulaire de Modification</h2>
        <form action="update_article" method="post">
            <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" value="<?= $article['title']; ?>"><br>
            <label for="content">Contenu :</label><br>
            <textarea id="content" name="content" rows="4" cols="50"><?= $article['content']; ?></textarea><br>
            <label for="status">Status :</label><br>
            <select id="status" name="status" required>
                <option value="published" <?= ($article['status'] === 'published') ? 'selected' : ''; ?>>Publié</option>
                <option value="pending" <?= ($article['status'] === 'pending') ? 'selected' : ''; ?>>En attente</option>
            </select><br>
            <input type="submit" value="Enregistrer les modifications">
        </form>
    </section>
</main>

<footer>

</footer>
</body>
</html>
