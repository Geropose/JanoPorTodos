<?php
class JanoMailer
{

    protected static function getMailer($subject,$fromName='Jano Por Todos',$replyTo='janoportodos@gmail.com')
    {
        $mailer = new \PHPMailer\PHPMailer\PHPMailer();
        //Server settings
        //$mailer->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mailer->isSMTP();                                            //Send using SMTP
        $mailer->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mailer->SMTPAuth = true;                                   //Enable SMTP authentication
        $mailer->Username = 'lucas.vidaguren@gmail.com';                     //SMTP username
        $mailer->Password = 'xhpqhfzpbziaxiru';                               //SMTP password
        $mailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mailer->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

        $mailer->isHTML(true);                                  //Set email format to HTML
        $mailer->setFrom('lucas.vidaguren@gmail.com', $fromName);

        $mailer->addAddress('janoportodos@gmail.com', 'Jano Por Todos');     //Add a recipient
        $mailer->addReplyTo($replyTo, $fromName);

        $mailer->Subject = $subject;

        return $mailer;
    }

    /**
     * @param $nombre
     * @param $email
     * @param $motivo
     * @param $propuestas
     * @param $horarios
     * @return \PHPMailer\PHPMailer\PHPMailer
     */
    public static function getMailerEmpresa($subject, $nombre, $email, $motivo, $propuestas, $horarios)
    {

        $mailer = self::getMailer($subject,$nombre. " ($email)",$email);
        $mailer->Body = "La empresa $nombre se desea contactar debido a  $motivo.
             Sus propuestas son: $propuestas.
             Los horarios disponibles son: $horarios. 
             Email: $email.";

        return $mailer;
    }

    /**
     * @param $nombre
     * @param $apellido
     * @param $nac
     * @param $telefono
     * @param $ciudad
     * @param $email
     * @param $oficio
     * @param $area
     * @param $capacitacion
     * @return \PHPMailer\PHPMailer\PHPMailer
     */
    public static function getMailerNoProfesionales($subject, $nombre, $apellido, $nac, $telefono, $ciudad, $email, $oficio, $area, $capacitacion)
    {
        $mailer = self::getMailer($subject,"$nombre $apellido ($email)");

        $mailer->Body = "Datos del voluntario:
            Nombre y apellido: $nombre $apellido. 
            Fecha de nacimiento: $nac. 
             Teléfono: $telefono. 
             Ciudad: $ciudad. 
             Email: $email. 
             Oficio: $oficio. 
             Posible área de desarrollo: $area. 
             Capacitación en: $capacitacion.";
        $mailer->addCC($email);
        return $mailer;
    }

    /**
     * @param $subject
     * @param $nombre
     * @param $email
     * @param $mensaje
     * @return \PHPMailer\PHPMailer\PHPMailer
     */
    public static function getMailerContacto($subject, $nombre, $email, $mensaje)
    {
        $mailer = self::getMailer($subject,"$nombre ($email)");
        $mailer->Body =
            "Nombre: $nombre
        Email: $email 
         $mensaje";
        return $mailer;
    }

    /**
     * @param $subject
     * @param $nombre
     * @param $email
     * @return \PHPMailer\PHPMailer\PHPMailer
     */
    public static function getMailerSuscripcion($subject, $nombre, $email)
    {
        $mailer = self::getMailer($subject,"$nombre $email");
        $mailer->Body =
            "Nombre: $nombre
         Email: $email";
        return $mailer;
    }

    public static function getMailerProfesionales($subject, $nombre, $apellido, $fechaNac, $telefono, $ciudad, $email, $profesion, $capacitacion, $CV)
    {
        $mailer = self::getMailer($subject,"$nombre $apellido ($email)");
        $mailer->addAddress('areapsicosocialjxt@gmail.com');
        $nombreAdjunto = $CV['name'];
        $mailer->Body =
            "Datos del profesional:
         Nombre y apellido: $nombre $apellido. 
         Fecha de nacimiento: $fechaNac. 
         Teléfono: $telefono. 
         Ciudad: $ciudad. 
         Email: $email. 
         Profesión: $profesion. 
         Capacitación en: $capacitacion.
         Nombre del archivo = $nombreAdjunto";

        $mailer->addAttachment($CV['tmp_name'], $nombreAdjunto);


        return $mailer;
    }
}