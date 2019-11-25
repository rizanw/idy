<?php

namespace Idy\Idea\Infrastructure;

use Idy\Idea\Domain\Model\Mail;
use Idy\Idea\Domain\Model\MailRepository;

class SmtpMailRepository implements MailRepository
{
    private $mail;
    private $senderName;
    private $senderMail;

    public function __construct($di, $senderName = null, $senderMail = null)
    {
        $this->mail = $di->get('smtp_mailer_client');
        $this->senderName = $senderName;
        $this->senderMail = $senderMail;
    }

    public function send(Mail $mail): bool
    {

        $this->mail->setFrom($this->senderMail, $this->senderName);
        $this->mail->addAddress($mail->toEmail(), $mail->toName());

        $this->mail->Subject = $mail->subject();
        $this->mail->MsgHTML($mail->message());
        $this->mail->CharSet = "utf-8";

        $isSend = $this->mail->send();
        return $isSend;
    }
}