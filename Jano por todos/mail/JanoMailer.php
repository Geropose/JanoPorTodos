<?php

class JanoMailer
{

    protected static function getBody($type, $vars)
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . "/html");
        $twig = new \Twig\Environment($loader, []);

        return $twig->render("$type.twig.html", $vars);
    }

    protected static function getMailer($subject, $fromName = 'Jano Por Todos', $replyTo = 'janoportodos@gmail.com')
    {
        $mailer = new \PHPMailer\PHPMailer\PHPMailer();
        //Server settings
        $mailer->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mailer->isSMTP();                                            //Send using SMTP
        $mailer->Host = $_ENV['SMTP_HOST'];                     //Set the SMTP server to send through
        $mailer->SMTPAuth = true;                                   //Enable SMTP authentication
        $mailer->Username = $_ENV['SMTP_USER'];                     //SMTP username
        $mailer->Password = $_ENV['SMTP_PASSWORD'];                               //SMTP password
        $mailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mailer->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

        $mailer->isHTML(true);                                  //Set email format to HTML
        $mailer->setFrom($_ENV['SMTP_FROM'], $fromName);

        $mailer->addAddress($_ENV['SMTP_TO'], 'Jano Por Todos');     //Add a recipient
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
        $mailer = self::getMailer($subject, $nombre . " ($email)", $email);
        $mailer->Body = self::getBody('empresa', compact('nombre', 'email', 'motivo', 'propuestas', 'horarios'));

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
    public static function getMailerNoProfesionales(
        $subject,
        $nombre,
        $apellido,
        $nac,
        $telefono,
        $ciudad,
        $email,
        $oficio,
        $area,
        $capacitacion
    ) {
        $mailer = self::getMailer($subject, "$nombre $apellido ($email)");

        $mailer->Body = self::getBody(
            'noProfesionales',
            compact(
                'nombre',
                'apellido',
                'nac',
                'telefono',
                'ciudad',
                'email',
                'oficio',
                'area',
                'capacitacion'
            )
        );
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
        $mailer = self::getMailer($subject, "$nombre ($email)");
        $mailer->Body = self::getBody('contacto',compact('nombre','email','mensaje'));
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
        $mailer = self::getMailer($subject, "$nombre $email");
        $mailer->Body = self::getBody('suscripcion', compact('nombre', 'email'));
        return $mailer;
    }

    public static function getMailerProfesionales(
        $subject,
        $nombre,
        $apellido,
        $fechaNac,
        $telefono,
        $ciudad,
        $email,
        $profesion,
        $capacitacion,
        $CV
    ) {
        $mailer = self::getMailer($subject, "$nombre $apellido ($email)");
        $mailer->addAddress('areapsicosocialjxt@gmail.com');
        $nombreAdjunto = $CV['name'];
        $mailer->Body = self::getBody('profesionales',compact('nombre','apellido','fechaNac',
                                                              'telefono','ciudad','email','profesion','capacitacion','nombreAdjunto'));

        $mailer->addAttachment($CV['tmp_name'], $nombreAdjunto);


        return $mailer;
    }
}