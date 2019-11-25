<?php

namespace Idy\Idea\Infrastructure;

use Phalcon\Db\Column;
use Idy\Idea\Domain\Model\Idea;
use Idy\Idea\Domain\Model\IdeaId;
use Idy\Idea\Domain\Model\Rating;
use Idy\Idea\Domain\Model\RatingRepository;

class SqlRatingRepository implements RatingRepository
{
    private $dbEngine;
    private $tableName;

    public function __construct($di)
    {
        $this->dbEngine = $di->get('db');
        $this->tableName = "ratings";
    }

    public function byIdeaId(IdeaId $id): array
    {
        $query = $this->dbEngine->prepare(
            "SELECT user, value
            FROM {$this->tableName}
            WHERE idea_id = :id"
        );
        $placeholders = [
            "id" => $id->id()
        ];
        $dataTypes = [
            "id" => Column::BIND_PARAM_STR
        ];
        $result = $this->dbEngine->executePrepared($query, $placeholders, $dataTypes);
        $ratingRows = $result->fetchAll();
        $ratings = array();
        foreach ($ratingRows as $row) {
            $rating = $this->buildRating($row);
            array_push($ratings, $rating);
        }
        return $ratings;
    }

    public function save(Rating $rating, IdeaId $id): bool
    {
        $placeholders = [
            "ideaId" => $id->id(),
            "user" => $rating->user(),
            "value" => $rating->value()
        ];
        $dataTypes = [
            "ideaId" => Column::BIND_PARAM_STR,
            "user" => Column::BIND_PARAM_STR,
            "value" => Column::BIND_PARAM_INT,
        ];
        $query =
            "INSERT INTO {$this->tableName}(idea_id, user, value) VALUE (:ideaId, :user, :value)";
        $isSuccessfullyExecuted = $this->dbEngine->execute($query, $placeholders, $dataTypes);
        return $isSuccessfullyExecuted;
    }

    private function buildRating(array $row): Rating
    {
        $rating = new Rating($row["user"], $row["value"]);
        return $rating;
    }

}