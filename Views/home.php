<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>JD-Blog - Accueil</title>
</head>
<body>
<header>
	<nav>
		<?php
		$router = require_once __DIR__ . '/../index.php';
		require_once 'Views/header.php';
		?>
	</nav>
</header>
<main class="d-flex mx-auto bg-secondary row">
    <section class="col col-8 mx-auto">
        <h2>Super BLOG</h2>
        <p>Une photo et/ou un logo</p>
        <p>Bienvenu sur mon blog</p>


        <a href="votre_cv.pdf">Télécharger CV</a>

        <div>
            <a href="https://github.com/Judes77850" target="_blank">GitHub</a>
            <a href="https://www.linkedin.com/in/julien-desaindes/" target="_blank">LinkedIn</a>
        </div>
    </section>
</main>

<footer>
	<nav>
		<ul>

		</ul>
	</nav>
</footer>
</body>
</html>
