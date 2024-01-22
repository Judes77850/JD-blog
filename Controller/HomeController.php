<?php

namespace Controller;

class HomeController {
	public function index() {
		// Instanciation du modèle HeaderModel
		$headerModel = new HeaderModel(new \PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+'));

		// Vérifier si l'utilisateur est connecté
		if (isset($_SESSION['user_id'])) {
			// Récupérer le pseudo de l'utilisateur
			$pseudo = $headerModel->getUserPseudo($_SESSION['user_id']);
		}

		// Inclure la vue de l'en-tête
		include __DIR__ . '/../Views/header.php';
		require __DIR__ . '/../index.php';
	}
}
