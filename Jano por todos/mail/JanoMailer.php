<?php

class JanoMailer
{
    protected $mailer;
    public function __construct()
    {
        $this->mailer =new \PHPMailer\PHPMailer\PHPMailer();
    }

    protected function getBody($type, $vars)
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . "/html");
        $twig = new \Twig\Environment($loader, []);

        return $twig->render("mail/$type.twig", $vars);
    }

    protected function getMailer($subject, $fromName = 'Jano Por Todos', $replyTo = 'janoportodos@gmail.com')
    {
        $mailer = new \PHPMailer\PHPMailer\PHPMailer();
        //Server settings
        //$mailer->SMTPDebug = \PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mailer->isSMTP();                                            //Send using SMTP
        $mailer->Host = $_ENV['SMTP_HOST'];                     //Set the SMTP server to send through
        $auth = filter_var(      $_ENV['SMTP_AUTH'], FILTER_VALIDATE_BOOLEAN);
        $mailer->SMTPAuth = $auth;                                   //Enable SMTP authentication
        $mailer->Username = $_ENV['SMTP_USER'];                     //SMTP username
        $mailer->Password = $_ENV['SMTP_PASSWORD'];                               //SMTP password
        $tls = filter_var(      $_ENV['SMTP_TLS'], FILTER_VALIDATE_BOOLEAN);
        if($tls)
            $mailer->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mailer->Port = $_ENV['SMTP_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

        $mailer->isHTML();                                  //Set email format to HTML
        $mailer->setFrom($_ENV['SMTP_FROM'], $fromName);

        $mailer->addAddress($_ENV['SMTP_TO'], 'Jano Por Todos');     //Add a recipient
        $mailer->addReplyTo($replyTo, $fromName);

        $mailer->Subject = $subject;
        $this->mailer =$mailer;
        return $mailer;
    }

    /**
     * @param $nombre
     * @param $email
     * @param $motivo
     * @param $propuestas
     * @param $horarios
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public  function sendMailerEmpresa($subject, $nombre, $email, $motivo, $propuestas, $horarios)
    {
        $mailer = $this->getMailer($subject, $nombre . " ($email)", $email);
        $mailer->Body = self::getBody('empresa', compact('nombre', 'email', 'motivo', 'propuestas', 'horarios'));
        $mailer->send();
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
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendMailerNoProfesionales(
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
        $mailer = $this->getMailer($subject, "$nombre $apellido ($email)");

        $mailer->Body = $this->getBody(
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
        $mailer->send();
    }

    /**
     * @param $subject
     * @param $nombre
     * @param $email
     * @param $mensaje
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendMailerContacto($subject, $nombre, $email, $mensaje)
    {
        $mailer = $this->getMailer($subject, "$nombre ($email)");
        $mailer->Body = $this->getBody('contacto',compact('nombre','email','mensaje'));
        $mailer->send();
    }

    /**
     * @param $subject
     * @param $nombre
     * @param $email
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendMailerSuscripcion($subject, $nombre, $email)
    {
        $mailer = $this->getMailer($subject, "$nombre $email");
        $mailer->Body = $this->getBody('suscripcion', compact('nombre', 'email'));
        $mailer->send();
    }

    /**
     * @param $subject
     * @param $nombre
     * @param $apellido
     * @param $fechaNac
     * @param $telefono
     * @param $ciudad
     * @param $email
     * @param $profesion
     * @param $capacitacion
     * @param $CV
     * @return void
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function sendMailerProfesionales(
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
        $mailer = $this->getMailer($subject, "$nombre $apellido ($email)");
        $mailer->addAddress('areapsicosocialjxt@gmail.com');
        $nombreAdjunto = $CV['name'];
        $mailer->Body = $this->getBody('profesionales',compact('nombre','apellido','fechaNac',
                                                              'telefono','ciudad','email','profesion','capacitacion','nombreAdjunto'));

        $mailer->addAttachment($CV['tmp_name'], $nombreAdjunto);


        $mailer->send();
    }

    public function getErrorInfo()
    {
        return $this->mailer->ErrorInfo;
    }


}