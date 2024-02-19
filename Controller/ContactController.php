<?php

namespace Controller;

use Twig\Environment;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController
{
	private $twig;

	public function __construct(Environment $twig)
	{
		$this->twig = $twig;
	}

	public function showContactForm()
	{
		$content = $this->twig->render('contact.twig');
		echo $content;
	}

	public function sendEmail()
	{
		$postData = $_POST;
		$name = $postData['name'];
		$email = $postData['email'];
		$subject = $postData['subject'];
		$message = $postData['message'];

		$mail = new PHPMailer(true);

		try {
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'julien.desaindes@gmail.com';
			$mail->Password = 'mzdfwafjzkpmgntv';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;

			$mail->setFrom($email, $name);
			$mail->addAddress('julien.desaindes@gmail.com');

			$mail->isHTML(false);
			$mail->Subject = $subject;
			$mail->Body = "Nom : $name\n";
			$mail->Body .= "E-mail : $email\n";
			$mail->Body .= "Sujet : $subject\n";
			$mail->Body .= "Message : $message\n";

			$mail->send();
			$content = $this->twig->render('contact_success.twig');
			echo $content;
		} catch (Exception $e) {
			echo 'Erreur lors de l\'envoi de l\'e-mail : ', $mail->ErrorInfo;
		}
	}
}