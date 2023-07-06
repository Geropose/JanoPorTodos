<?php
require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['formType'];
    $mailer = new \Jano\JanoMailer();

    try {
        if ($formType === 'empresa') {
            // Procesamiento del formulario de contacto
            $mailer->sendMailerEmpresa('Mensaje de contacto de empresa', $_POST['nombreEmpresa'], $_POST['emailEmpresa'], $_POST['motivo'], $_POST['propuestas'], $_POST['horarioDisp']);

        } elseif ($formType === 'no profesionales') {
            $mailer->sendMailerNoProfesionales('Mensaje de voluntario no profesional', $_POST['nombre'], $_POST['apellido'], $_POST['fechaNac'],
                $_POST['telefono'], $_POST['ciudad'], $_POST['email'], $_POST['oficio'], $_POST['area'], $_POST['capacitacion']);
        } elseif ($formType === 'contacto') {
            $mailer->sendMailerContacto($_POST['asunto'], $_POST['nombre'], $_POST['email'], $_POST['mensaje']);
        } elseif ($formType === 'suscripcion') {
            $mailer->sendMailerSuscripcion("Nueva suscripción", $_POST['nombre'], $_POST['email']);
        } elseif ($formType === 'profesionales') {
            $mailer->sendMailerProfesionales('Mensaje de voluntario profesional', $_POST['nombre'], $_POST['apellido'],
                $_POST['fechaNac'], $_POST['telefono'], $_POST['ciudad'], $_POST['email'], $_POST['profesion'], $_POST['capacitacion'], $_FILES['CV']);
        } else {
            echo 'Tipo de formulario inválido.';
        }

        header('Content-type: application/json');
        echo json_encode(['status' => 'OK', 'message' => 'Correo enviado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'ERR', 'message' => 'Error al enviar el correo.' . $mailer->getErrorInfo()]);
    }
}