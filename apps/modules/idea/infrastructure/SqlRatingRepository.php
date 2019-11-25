<?php 

namespace Idy\Idea\Infrastructure;

use Phalcon\Db\Column;
use Phalcon\Mvc\Model\Query;
use Idy\Idea\Domain\Model\Author;
use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\IdeaRepository;

class SqlIdeaRepository implements RatingRepository
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
        $query = $this->dbEngine->prepare("SELECT 1 FROM {$this->tableName} WHERE id=:id;");
        $dataTypes = [
            "id" => Column::BIND_PARAM_STR
        ];
        $dataValues = [
            "id" => $id->id()
        ];

        $res = $this->dbEngine->executePrepared($query, $dataValues, $dataTypes);
        $anyIdea = $res->fetch();

        return $anyIdea;
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
        $isExist = $this->isExist($idea->id());

        if(!$isExist){
            $query =
                "INSERT INTO {$this->tableName}(id, title, description, author_name, author_email, votes)
                VALUE (:id, :title, :description, :authorName, :authorEmail, :votes)";
        }else{
            $query =
                "UPDATE {$this->tableName} SET
                title=:title, description=:description, author_name=:authorName,
                author_email=:authorEmail, votes=:votes
                WHERE id = :id";
        }

        $isSuccessfullyExecuted = $this->dbEngine->execute($query, $dataValues, $dataTypes);
        return $isSuccessfullyExecuted;
    }

    public function allIdeas() : array
    {
        $query = "SELECT id, title, description, author_name, author_email, votes FROM {$this->tableName};";
        $result = $this->dbEngine->query($query);
        $ideaData = $result->fetchAll();
        $ideas = array();
        foreach ($ideaData as $val){
            $idea = $this->buildIdea($val);
            array_push($ideas, $idea);
        }
        return $ideas;
    }

    public function buildIdea(array $val) : Idea
    {
        # code...
        $ideaId = new IdeaId($val['id']);
        $ideaAuthor = new Author($val['author_name'], $val['author_email']);
        $idea = new Idea(
            $ideaId,
            $val['title'],
            $val['description'],
            $ideaAuthor,
            $val['votes']
        );
        return $idea;
    }
    
}