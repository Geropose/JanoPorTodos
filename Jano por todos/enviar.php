<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formType = $_POST['formType'];

    if ($formType === 'empresa') {
        // Procesamiento del formulario de contacto
        $nombre = $_POST['nombreEmpresa'];
        $email = $_POST['emailEmpresa'];
        $motivo = $_POST['motivo'];
		$propuestas = $_POST['propuestas'];
		$horarios = $_POST['horarioDisp'];

		$mensaje = "La empresa $nombre se desea contactar debido a  $motivo.\n Sus propuestas son: $propuestas.\n Los horarios disponibles son: $horarios. \n Email: $email.";

        $to = 'janoportodos@gmail.com';
        $subject = 'Mensaje de contacto de empresa';

        if (mail($to, $subject, $mensaje)) {
            echo 'Correo de contacto enviado exitosamente.';
        } else {
            echo 'Error al enviar el correo de contacto.';
        }
    } elseif ($formType === 'no profesionales') {

        $nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$nac = $_POST['fechaNac'];
		$telefono = $_POST['telefono'];
		$ciudad = $_POST['ciudad'];
        $email = $_POST['email'];
        $oficio = $_POST['oficio'];
		$area = $_POST['area'];
		$capacitacion = $_POST['capacitacion'];

        $to = 'janoportodos@gmail.com';
        $subject = 'Mensaje de voluntario no profesional';
        $mensaje = "Datos del voluntario:\n Nombre y apellido: $nombre $apellido. \n Fecha de nacimiento: $nac. \n Teléfono: $telefono. \n Ciudad: $ciudad. \n Email: $email. \n Oficio: $oficio. \n Posible área de desarrollo: $area. \n Capacitación en: $capacitacion.";

        if (mail($to, $subject, $mensaje)) {
            echo 'Correo de suscripción enviado exitosamente.';
        } else {
            echo 'Error al enviar el correo de suscripción.';
        }
    }
    elseif ($formType === 'contacto') {

        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
		$asunto = $_POST['asunto'];
		$mensaje = "Nombre: $nombre \n. Email: $email \n . " + $_POST['mensaje'];
    
        $to = 'janoportodos@gmail.com';

        if (mail($to, $asunto, $mensaje)) {
            echo 'Correo de suscripción enviado exitosamente.';
        } else {
            echo 'Error al enviar el correo de suscripción.';
        }
    }
	elseif ($formType === 'profesionales') {

        $nombre = $_POST['nombre'];
		$apellido = $_POST['apellido'];
		$nac = $_POST['fechaNac'];
		$telefono = $_POST['telefono'];
		$ciudad = $_POST['ciudad'];
        $email = $_POST['email'];
		$profesion = $_POST['profesion'];
		$capacitacion = $_POST['capacitacion'];
		$cv = $_FILES['CV'];
        // Ruta temporal del archivo adjunto
        $archivo_temporal = $_FILES["CV"]["tmp_name"];
        
        // Nombre original del archivo adjunto
        $nombre_adjunto = $_FILES["CV"]["name"];
        
        // Contenido del archivo adjunto
        $contenido_adjunto = file_get_contents($archivo_temporal);
        
        $to = 'areapsicosocialjxt@gmail.com';
        $subject = 'Mensaje de voluntario profesional';
        $mensaje = "Datos del profesional:\n Nombre y apellido: $nombre $apellido. \n Fecha de nacimiento: $nac. \n Teléfono: $telefono. \n Ciudad: $ciudad. \n Email: $email. \n Profesión: $profesion. \n Capacitación en: $capacitacion.";
        
        // Adjuntar el archivo al mensaje
        $mensaje .= "Nombre del archivo = $nombre_adjunto\n";
        $mensaje_correo .= chunk_split(base64_encode($contenido_adjunto)) . "\r\n";

        if (mail($to, $subject, $mensaje)) {
            echo 'Correo de suscripción enviado exitosamente.';
        } else {
            echo 'Error al enviar el correo de suscripción.';
        }
    } else {
        echo 'Tipo de formulario inválido.';
    }
}
?>