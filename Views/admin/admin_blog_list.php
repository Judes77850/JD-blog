<?php
$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

$user_id = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT * FROM articles WHERE author = ? order by articles.created_at desc");
$query->execute([$user_id]);
$articles = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<main>
    <section class="content mt-5">
        <h2 class="mb-5">Gérer mes Articles</h2>
		<?php if (count($articles) > 0) : ?>
            <div class="d-flex flex-wrap justify-content-start align-items-center">
				<?php foreach ($articles as $article) : ?>
                    <div class="card">
                        <img class="card-img-top" src="<?= $article['image_path']; ?>" alt="Image de l'article">
                        <div class="card-body">
                            <h3 class="card-title"><?= $article['title']; ?></h3>
                            <p class="card-text "><?= $article['chapo']; ?> <br/><?= $article['status']; ?></p>
							<?php if (isset($article['id'])) : ?>
                            <span class="w-75 mx-auto d-flex justify-content-between align-items-center">
                                <form action="../delete_article" method="post">
                                    <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
                                    <input class="btn btn-danger" type="submit" value="Supprimer">
                                </form>
                                <form action="/edit_single_article?id=<?= $article['id']; ?>" method="get">
                                    <input type="hidden" name="article_id" value="<?= $article['id']; ?>">
                                    <input class="btn btn-info" type="submit" value="Modifier">
                                </form>
                            </span>
							<?php else: ?>
                                <p>Erreur : ID de l'article non défini</p>
							<?php endif; ?>
                        </div>
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
