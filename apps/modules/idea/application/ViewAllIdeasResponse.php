<?php

namespace Idy\Idea\Application;

class ViewAllIdeasResponse
{
    public $ideas;

    public function __construct($ideas)
    {
        $this->ideas = $ideas; 
    }
}