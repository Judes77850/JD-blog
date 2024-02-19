<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email = $_POST["email"];
	$password = $_POST["password"];
	$pseudo = $_POST["pseudo"];

	$pdo = new PDO('mysql:host=localhost;dbname=jdblog', 'root', 'Julien77@+');

	$query = $pdo->prepare("SELECT * FROM user WHERE email = ?");
	$query->execute([$email]);
	$user = $query->fetch(PDO::FETCH_ASSOC);

	if ($user && password_verify($password, $user['password'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['user_role'] = $user['role'];
		$_SESSION['user_email'] = $user['email'];
		$_SESSION['user_firstname'] = $user['firstname'];
		$_SESSION['user_lastname'] = $user['lastname'];
		$_SESSION['user_pseudo'] = $user['pseudo'];
		header("Location: /");
		exit();
	} else {

		header("Location: register");
		exit();
	}
}

