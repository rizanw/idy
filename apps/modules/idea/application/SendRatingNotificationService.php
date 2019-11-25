<?php

namespace Idy\Idea\Application;

use Idy\Idea\Domain\Model\Mail;
use Idy\Idea\Domain\Model\MailRepository;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\IdeaRepository;

class SendRatingNotificationService
{
    private $mailRepository;
    private $ideaRepository;

    public function __construct(MailRepository $mailRepository, IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
        $this->mailRepository = $mailRepository;
    }

    public function execute($ideaId, $ratingValue)
    {
        $ideaId = new IdeaId($ideaId);
        $idea = $this->ideaRepository->byId($ideaId);

        $toName = $idea->author()->name();
        $toEmail = $idea->author()->email();
        $subject = "You got a new rating!";
        $message = file_get_contents(APP_PATH . '/modules/idea/views/mail/idea_rated_plain.volt');
        $message = str_replace('%name%', $idea->author()->name(), $message);
        $message = str_replace('%id%', $idea->id()->id(), $message);
        $message = str_replace('%rating%', $ratingValue, $message);

        $mail = new Mail($toName, $toEmail, $subject, $message);
        $this->mailRepository->send($mail);
    }
}