<?php
namespace Idy\Idea\Application;
class ViewIdeaRequest
{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}