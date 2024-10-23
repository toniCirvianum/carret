<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



class Mailer extends PHPMailer
{
    function mailServerSetup()
    {
        //Server settings
        // $this->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $this->isSMTP(); //Send using SMTP
        $this->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $this->SMTPAuth = true; //Enable SMTP authentication
        $this->Username = MAIL; //SMTP username
        $this->Password = CREDENTIAL_MAIL; //SMTP password
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
        $this->Port = 465; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    }

    // function addRec($to, $cc = array(), $bcc = array())
    function addRec($mail,$name)
    {
        $this->setFrom('phpmailer.'.MAIL,NAME_MAIL);
        // foreach ($to as $address) {
            $this->addAddress($mail, $name);
        // }
        // foreach ($cc as $address) {
        //     $this->addCC($address);
        // }
        // foreach ($bcc as $address) {
        //     $this->addBCC($address);
        // }
    }

    function addAttachments($att)
    {
        foreach ($att as $attachment) {
            $this->addAttachment($attachment);
        }
    }

    function addVerifyContent($user = [])
    {
        $this->isHTML(true);
        $this->Subject = 'Verify your email please...';
        $content = "<p>Hi ".$user['name']." </p>";
        $content .= "<p>Click follow button in order to verify your email</p>";
        $content .= "<a style='padding: 4px; background-color: red; color:white; 
        text-decoration-color: unset;' href='http://localhost/user/verify/".$user['username']."/".$user['token']."'>Verify!</a>";
        $this->Body = $content;

    }


}