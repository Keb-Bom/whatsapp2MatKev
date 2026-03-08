<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService {

    public function sendPassword($toEmail, $password) {

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'TU_CORREO@gmail.com';
            $mail->Password = 'TU_APP_PASSWORD';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('TU_CORREO@gmail.com', 'Chat App');
            $mail->addAddress($toEmail);

            $mail->isHTML(true);
            $mail->Subject = 'Tu contraseña';
            $mail->Body = "Tu contraseña es: <b>$password</b>";

            $mail->send();

            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}