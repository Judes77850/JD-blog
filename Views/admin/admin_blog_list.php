<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration - Gérer les Articles</title>
</head>
<body>

<?php
$router = require_once __DIR__ . '/../../index.php';
require_once 'Views/header.php';
?>

<ul class="d-flex list-unstyled w-50 mx-auto justify-content-between">
    <li><a href="admin_home.php">Accueil Administration</a></li>
    <li><a href="/add_blog_article">Créer un article</a></li>
    <li><a href="admin_edit_profile.php">Modifier Profil</a></li>
</ul>
<?php
$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM articles WHERE author = ? order by articles.created_at desc");
$query->execute([$user_id]);
$articles = $query->fetchAll(PDO::FETCH_ASSOC);

?>


<main>
    <section>
        <h2>Gérer mes Articles</h2>
		<?php if (count($articles) > 0) : ?>
            <div class="d-flex flex-wrap justify-content-between">
				<?php foreach ($articles as $article) : ?>
                    <div class="card p-4">
                        <h3><?= $article['title']; ?></h3>
                        <p><?= $article['chapo']; ?></p>
                        <p><?= $article['status']; ?></p>
                        <form action="../delete_article" method="post">
                            <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
                            <input type="submit" value="Supprimer">
                        </form>
                        <form action="/edit_single_article" method="get">
                            <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
                            <input type="submit" value="Modifier">
                        </form>
                    </div>
				<?php endforeach; ?>
            </div>
		<?php else : ?>
            <p>Aucun article trouvé.</p>
		<?php endif; ?>
    </section>
</main>

</body>
</html>
