<?php

namespace Idy\Idea\Domain\Model;

class Mail{
    const DEFAULT_SENDER_NAME = null;
    const DEFAULT_SENDER_EMAIL = null;
    private $toName;
    private $toEmail;
    private $subject;
    private $message;

    public function __construct($toName, $toEmail, $subject, $message)
    {
        $this->toName = $toName;
        $this->toEmail = $toEmail;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function toName()
    {
        return $this->toName;
    }

    public function toEmail()
    {
        return $this->toEmail;
    }

    public function subject()
    {
        return $this->subject;
    }

    public function message()
    {
        return $this->message;
    }
}