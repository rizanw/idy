<?php

namespace Idy\Idea\Application;

class SendRatingNotificationRequest
{
    public $ratingValue;
    public $ideaId;

    public function __construct($ideaId, $ratingValue)
    {
        $this->ideaId = $ideaId;
        $this->ratingValue = $ratingValue;
    }

}