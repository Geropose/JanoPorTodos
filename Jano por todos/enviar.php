<?php 
	// $form = $_POST['empresa'];
	// if ($form == 'empresa'){
// 		$nombre =  strip_tags(htmlspecialchars($_POST['nombreEmpresa']));
// 		$email =  strip_tags(htmlspecialchars($_POST['emailEmpresa']));
// 		$propuestas =  strip_tags(htmlspecialchars($_POST['propuestas']));
// 		$motivo =  strip_tags(htmlspecialchars($_POST['motivo']));
// 		$horario =  strip_tags(htmlspecialchars($_POST['horarioDisp']));
// 		$asunto = "Una empresa quiere contactarse";
// 	// }
// 	$mensaje = "La empresa: ".$nombre." quiere contactarse con ustedes <br> Su email: " .$email. " <br> Motivo de contacto: ".$motivo."<br> Propuestas de acciones de colaboración: ".$propuestas. "<br> Dias y horarios disponibles: ".$horario;


// if(mail("amaikegopar60@gmail.com", $asunto, $mensaje,"agopar@alumnos.exa.unicen.edu.ar"))
//   echo "enviado";
$to_email = "amaikegopar60@gmail.com";
$subject = "Simple Email Test via PHP";
$body = "Hi,nn This is test email send by PHP Script";
$headers = "From: yo";

if (mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
	echo "No se envio";
    header("Location: http://localhost/jano%20por%20todos%20gero/home.html");
	exit();
}
?>

