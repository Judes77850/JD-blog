<?php

$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

$article_id = $_GET['article_id'];
$user_id = $_SESSION['user_id'];

$query = $pdo->prepare("SELECT * FROM articles WHERE id = ? AND author = ?");
$query->execute([$article_id, $user_id]);
$article = $query->fetch(PDO::FETCH_ASSOC);

if (!$article) {
	header("Location: edit_single_article.php?article_id=$article_id");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$title = $_POST["title"];
	$content = $_POST["content"];
	$status = $_POST["status"];
	$new_image_path = isset($_POST["new_image_path"]) ? $_POST["new_image_path"] : null;

	if (!empty($new_image_path)) {
		$image_path = "../uploads/" . $new_image_path;
	} else {
		$image_path = $article['image_path'];
	}

	try {
		$query = $pdo->prepare("UPDATE articles SET title = ?, content = ?, image_path = ?, status = ? WHERE id = ?");
		$query->execute([$title, $content, $image_path, $status, $article_id]);
		header("Location: edit_single_article.php?article_id=$article_id");
		exit();
	} catch (PDOException $e) {
		echo "Erreur lors de la mise à jour de l'article : " . $e->getMessage();
	}
}
?>

<main>
    <section class="content my-5">
        <h2>Formulaire de Modification</h2>
        <form class="bg-black text-light p-3 rounded-3 w-75 mx-auto mt-5 d-flex flex-column justify-content-center " action="update_article" method="post" enctype="multipart/form-data">
            <input class="form-control" type="hidden" name="article_id" value="<?= $article['id']; ?>">
            <label class="form-label" for="title">Titre :</label>
            <input class="form-control" type="text" id="title" name="title" value="<?= $article['title']; ?>"><br>
            <label class="form-label" for="content">Contenu :</label><br>
            <textarea class="form-control" id="content" name="content" rows="4" cols="50"><?= $article['content']; ?></textarea><br>
            <label class="form-label" for="image">Image (moins de 2mo) :</label><br>
            <input class="form-control" type="file" id="image" name="image" accept="image/*"><br>
			<?php if ($article['image_path']): ?>
                <input type="hidden" name="new_image_path" value="<?= basename($article['image_path']); ?>">
                <img class="w-50 mx-auto bg-white" src="<?= $article['image_path']; ?>" alt="Image actuelle">
			<?php endif; ?><br>
            <label class="form-label" for="status">Status :</label><br>
            <select class="form-control" id="status" name="status" required>
                <option value="published" <?= ($article['status'] === 'published') ? 'selected' : ''; ?>>Publié</option>
                <option value="pending" <?= ($article['status'] === 'pending') ? 'selected' : ''; ?>>En attente</option>
            </select><br>
            <input class="btn btn-light" type="submit" value="Enregistrer les modifications">
        </form>
    </section>
</main>
