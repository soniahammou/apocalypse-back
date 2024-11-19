<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService  

{
    private $symfoMailer;
    private $fromEmail ;
    private $defaultToEmail ;
    private $appMailDev ;

    
    public function __construct(MailerInterface $mailer, $fromEmail,  bool $appMailDev, $defaultToEmail = '')
    {
        $this->symfoMailer = $mailer;
        $this->fromEmail = $fromEmail;
        $this->appMailDev = $appMailDev;
        $this->defaultToEmail = $defaultToEmail;

    }

    public function sendWelcomeMessage($toEmail, $firstname, $lastname)
    {
        //  si on a un paramètre APP_MAIL_DEV = true, alors on envoie tous les mails à une certaine adresse
        if ($this->appMailDev && ! empty($this->defaultToEmail))
        {
            $toEmail = $this->defaultToEmail;
        }
        $email = (new Email())
            ->from('postmaster@sandbox81dabc8af7b546829b77eb1cb2524c40.mailgun.org')
            ->to($toEmail)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Bienvenu'  .' '.  $firstname .' '. $lastname .' '. 'sur Appocalypse')
            ->text('Votre compte a bien été créé ! ');
            //->html('<p>See Twig integration for better HTML integration!</p>');

        $this->symfoMailer->send($email);

    }

}