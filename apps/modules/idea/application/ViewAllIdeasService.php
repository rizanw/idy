<?php

namespace Idy\Idea\Application;

use Idy\Idea\Domain\Model\IdeaRepository;
use Idy\Idea\Domain\Model\RatingRepository;

class ViewAllIdeasService
{
    private $ideaRepository;
    private $ratingRepository;

    public function __construct(IdeaRepository $ideaRepository)//, RatingRepository $ratingRepository)
    {
        $this->ideaRepository = $ideaRepository;
        // $this->ratingRepository = $ratingRepository;
    }

    public function execute()
    {
        # code...
        $ideas = array();
        foreach($this->ideaRepository->allIdeas() as $idea){
            array_push($ideas, $idea);
        }
        $res = new ViewAllIdeasResponse($ideas);
        return $ideas;
    }
}