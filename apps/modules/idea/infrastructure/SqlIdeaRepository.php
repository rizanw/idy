<?php 

namespace Idy\Idea\Infrastructure;

use Phalcon\Db\Column;
use Idy\Idea\Domain\Model\Author;
use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\IdeaRepository;

class SqlIdeaRepository implements IdeaRepository
{
    private $ideas;
    private $tableName;
    private $dbEngine;

    public function __construct($di)
    {
        $this->ideas = array();
        $this->tableName = "ideas";
        $this->dbEngine = $di->get('db');
    }

    public function byId(IdeaId $id)
    {

    }
    
    public function isExist(IdeaId $id) : bool
    {
        $query = "SELECT 1 FROM {$this->ideaTableName} WHERE id = :id;";
        $dataTypes = [
            "id" => Column::BIND_PARAM_STR
        ];
        $dataValues = [
            "id" => $id->id()
        ];

        $res = $this->dbEngine->execute($query, $dataValues, $dataTypes);
        $anyIdea = $res->fetch();

        return !($anyIdea == false);
    }

    public function save(Idea $idea) : bool
    {
        $query = "";
        $dataTypes = [
            "id" => Column::BIND_PARAM_STR,
            "title" => Column::BIND_PARAM_STR,
            "description" => Column::BIND_PARAM_STR,
            "authorName" => Column::BIND_PARAM_STR,
            "authorEmail" => Column::BIND_PARAM_STR,
            "votes" => Column::BIND_PARAM_INT
        ];
        $dataValues = [
            "id" => $idea->id()->id(),
            "title" => $idea->title(),
            "description" => $idea->description(),
            "authorName" => $idea->author()->name(),
            "authorEmail" => $idea->author()->email(),
            "votes" => $idea->votes()
        ];
        $isSuccessfullyExecuted = false;

        if(!$this->isExist($idea->id())){
            $query =
                "INSERT INTO {$this->ideaTableName}(id, title, description, author_name, author_email, votes)
                VALUE (:id, :title, :description, :authorName, :authorEmail, :votes)";
        }else{
            $query =
                "UPDATE {$this->ideaTableName} SET
                title=:title, description=:description, author_name=:authorName,
                author_email=:authorEmail, votes=:votes
                WHERE id = :id";
        }

        print_r($query); exit;

        $isSuccessfullyExecuted = $this->dbEngine->execute($query, $dataValues, $dataTypes);
        return $isSuccessfullyExecuted;
    }

    public function allIdeas()
    {

    }
    
}