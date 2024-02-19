<?php

$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

$article_id = $_GET['article_id'];
$user_id = $_SESSION['user_id'];

$query = $pdo->prepare("SELECT * FROM articles WHERE id = ? AND author = ?");
$query->execute([$article_id, $user_id]);
$article = $query->fetch(PDO::FETCH_ASSOC);

if (!$article) {
	header("Location: edit_single_article.php");
	exit();
}
?>

<main>
    <section>
        <h2>Formulaire de Modification</h2>
        <form action="update_article" method="post" enctype="multipart/form-data">
            <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" value="<?= $article['title']; ?>"><br>
            <label for="content">Contenu :</label><br>
            <textarea id="content" name="content" rows="4" cols="50"><?= $article['content']; ?></textarea><br>
            <label for="image">Image (moins de 2mo) :</label><br>
            <input type="file" id="image" name="image" accept="image/*"><br>
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
