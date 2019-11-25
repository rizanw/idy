<?php

namespace Idy\Idea\Domain\Model;

use Idy\Common\Events\DomainEventPublisher;
use Phalcon\Exception;

class Idea
{
    private $id;
    private $title;
    private $description;
    private $author;
    private $ratings;
    private $votes;

    public function __construct(IdeaId $id, $title, $description, Author $author, $vote)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->author = $author;
        $this->ratings = array();
        $this->votes = $vote;
    }

    public function id()
    {
        return $this->id;
    }

    public function title()
    {
        return $this->title;
    }

    public function description()
    {
        return $this->description;
    }

    public function author()
    {
        return $this->author;
    }

    public function votes()
    {
        return $this->votes;
    }

    public function ratings()
    {
        return $this->ratings;
    }

    public function loadRatings(array $ratings){
        $this->ratings = $ratings;
    }

    public function addRating($newRating)
    {

        if ($newRating->isValid()) {
            $isUserExist = false;
            foreach ($this->ratings as $oldRating) {
                if ($oldRating->user() == $newRating->user()) {
                    $isUserExist = true;
                }
            }

            if (!$isUserExist) {
                array_push($this->ratings, $newRating);
            } else {
                exit('user ' . $newRating->user() . ' has giving a rating.');
            }

            DomainEventPublisher::instance()->publish(new IdeaRated($this->author->name(), $this->author->email(), $this->title, $newRating->value()));
        }
    }

    public function vote()
    {
        $this->votes = $this->votes + 1;
    }

    public function averageRating()
    {
        $totalRatings = 0;
        $numberOfRatings = count($this->ratings);
        foreach ($this->ratings as $rating) {
            $totalRatings += $rating->value();
        }

        $res = 0;
        if ($numberOfRatings > 0) {
            $res = $totalRatings / $numberOfRatings;
        }

        return $res;
    }

    public static function makeIdea($title, $description, $author)
    {
        $newIdea = new Idea(new IdeaId(), $title, $description, $author, 0);

        return $newIdea;
    }

}