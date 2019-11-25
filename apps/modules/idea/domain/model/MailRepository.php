<?php

namespace Idy\Idea\Domain\Model;

interface MailRepository
{
    public function send(Mail $mail) : bool;
}