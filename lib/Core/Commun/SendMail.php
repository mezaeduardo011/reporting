<?php
namespace JPH\Core\Commun;
use PHPMailer\PHPMailer\PHPMailer;
use JPH\Core\Store\Cache;

/**
 * Clase encargada de gestionar todas las Exceptions del sistema con el objetivo de implementar
 * las acciones de errores pertenecientes a las fallas del sistema y e
 * @author: Gregorio Bolívar <elalconxvii@gmail.com>
 * @author: Blog: <http://gbbolivar.wordpress.com>
 * @created Date: 26/07/2017
 * @version: 0.1
 */

trait SendMail
{
    public $mail;

    public function __construct()
    {
        //Create a new PHPMailer instance
        $this->mail = new PHPMailer;

        //Tell PHPMailer to use SMTP
        $this->mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->mail->SMTPDebug = Cache::get('smtp_debug');

        //Ask for HTML-friendly debug output
        $this->mail->Debugoutput = 'html';
        //die(Cache::get('smtp_server'));
        //Set the hostname of the mail server
        $this->mail->Host = Cache::get('smtp_server');//'smtp.gmail.com';

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $this->mail->Port = Cache::get('smtp_port');//587;

        //Set the encryption system to use - ssl (deprecated) or tls
        $this->mail->SMTPSecure = Cache::get('smtp_SMTPSecure');;

        //Whether to use SMTP authentication
        $this->mail->SMTPAuth = Cache::get('smtp_SMTPAuth');

        //Username to use for SMTP authentication - use full email address for gmail
        $this->mail->Username = Cache::get('smtp_user');//"username@gmail.com";

        //Password to use for SMTP authentication
        $this->mail->Password = Cache::get('smtp_pass');//"yourpassword";

        //Set who the message is to be sent from
        $this->mail->setFrom(Cache::get('smtp_user'), 'Server');

    }
    /**
     * Encargado de enviar los mensajes de correos de todo el sistema
     * @param array $correos
     * @return string $datos
     */
    public function send(){
        ### Remitentes

        //Set who the message is to be sent to
        $this->mail->addAddress('elalconxvii@gmail.com', 'John Doe');

        //Set an alternative reply-to address
        $this->mail->addReplyTo('elalconxvii@hotmail.com', 'First Last');

        /*
         $this->mail->addCC('cc@example.com');
         $this->mail->addBCC('bcc@example.com');
        */

        ###### Content #####
        // Set email format to HTML
        $this->mail->isHTML(true);

        //Set the subject line
        $this->mail->Subject = 'PHPMailer GMail SMTP test';

        //convert HTML into a basic plain-text alternative body
        $this->mail->Body = 'Here is the subject';

        //Replace the plain text body with one created manually
        $this->mail->AltBody = 'This is a plain-text message body';

        ###### Attach an image file #####
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            print_r($this->mail->send());


        //send the message, check for errors
        if (!$this->mail->send()) {
            $datos['mensaje'] = "Mailer Error: " . $this->mail->ErrorInfo;
            $datos['error'] = 1;
        } else {
            $datos['mensaje'] = 'Message sent!';
            $datos['error'] = 0;
        }

        return $datos;
    }

}

?>
