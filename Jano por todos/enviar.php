<?php
 require_once "vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

 require_once "mail/JanoMailer.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['formType'];

    if ($formType === 'empresa') {
        // Procesamiento del formulario de contacto
        $mailer = JanoMailer::getMailerEmpresa('Mensaje de contacto de empresa', $_POST['nombreEmpresa'], $_POST['emailEmpresa'], $_POST['motivo'], $_POST['propuestas'], $_POST['horarioDisp']);

    } elseif ($formType === 'no profesionales') {
        $mailer = JanoMailer::getMailerNoProfesionales('Mensaje de voluntario no profesional', $_POST['nombre'], $_POST['apellido'], $_POST['fechaNac'],
            $_POST['telefono'], $_POST['ciudad'], $_POST['email'], $_POST['oficio'], $_POST['area'], $_POST['capacitacion']);
    } elseif ($formType === 'contacto') {
        $mailer = JanoMailer::getMailerContacto($_POST['asunto'], $_POST['nombre'], $_POST['email'], $_POST['mensaje']);
    } elseif ($formType === 'suscripcion') {
        $mailer = JanoMailer::getMailerSuscripcion("Nueva suscripción", $_POST['nombre'], $_POST['email']);
    } elseif ($formType === 'profesionales') {
        $mailer = JanoMailer::getMailerProfesionales('Mensaje de voluntario profesional', $_POST['nombre'], $_POST['apellido'],
            $_POST['fechaNac'], $_POST['telefono'], $_POST['ciudad'], $_POST['email'], $_POST['profesion'], $_POST['capacitacion'], $_FILES['CV']);
    } else {
        echo 'Tipo de formulario inválido.';
    }

    header('Content-type: application/json');
    try {
        $mailer->send();
        echo json_encode(['status'=>'OK','message'=>'Correo enviado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['status'=>'OK','message'=>'Error al enviar el correo.' . $mailer->ErrorInfo]);
    }
}