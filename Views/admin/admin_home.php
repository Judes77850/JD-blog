<main>
    <div class="content mt-5 h-75">
        <h2>Bienvenue dans l'espace d'administration</h2>
        <div class="mt-5">
            <p>Ici, vous pourrez gérer les articles, modifier votre profil, etc.</p>
            <div class="d-flex justify-content-center">
                <btn class="btn btn-dark m-2"><a class="text-light" href="/add_blog_article">Créer un article</a></btn>
                <btn class="btn btn-dark m-2"><a class="text-light" href="/admin_blog_list">Gérer mes Articles</a></btn>
                <btn class="btn btn-dark m-2"><a class="text-light" href="admin_edit_profil">Modifier Profil</a></btn>
            </div>
        </div>
    </div>
</main>
<?php
require_once 'Views/footer.php'
?>