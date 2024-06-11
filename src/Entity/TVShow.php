<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\SeasonCollection;
use Entity\Exception\EntityNotFoundException;

class TVShow
{
    private ?int $id;
    private string $name;
    private string $originalName;
    private string $homepage;
    private string $overview;
    private ?int $posterId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getHomepage(): string
    {
        return $this->homepage;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    public function getSeasons(): array
    {
        return SeasonCollection::findByTvShowId($this->id);
    }

    public function setId(?int $id): TVShow
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): TVShow
    {
        $this->name = $name;
        return $this;
    }

    public function setOriginalName(string $originalName): TVShow
    {
        $this->originalName = $originalName;
        return $this;
    }

    public function setHomepage(string $homepage): TVShow
    {
        $this->homepage = $homepage;
        return $this;
    }

    public function setOverview(string $overview): TVShow
    {
        $this->overview = $overview;
        return $this;
    }

    public function setPosterId(?int $posterId): TVShow
    {
        $this->posterId = $posterId;
        return $this;
    }

    public function delete(): TVShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            DELETE
            FROM tvshow
            WHERE id = ?
            SQL
        );
        $stmt->execute([$this->id]);

        $this->id = null;

        return $this;
    }

    public function update(): TVShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            UPDATE tvshow
            SET name = :name, originalName = :og, homepage = :hp, overview = :overview, posterId = :pId
            WHERE id = :id
            SQL
        );

        $stmt->execute([
            'name' => $this->name,
            'og' => $this->originalName,
            'hp' => $this->homepage,
            'overview' => $this->overview,
            'pId' => $this->posterId,
            'id' => $this->id
        ]);

        return $this;
    }

    public function insert(): TVShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            INSERT INTO
            tvshow(name,originalName,homepage,overview,posterId)
            VALUES(?,?,?,?,?)
            SQL
        );

        $stmt->execute([$this->name, $this->originalName, $this->homepage, $this->overview, $this->posterId]);

        $lastId = (int) MyPdo::getInstance()->lastInsertId();

        return $this->setId($lastId);
    }

    public function save(): TVShow
    {
        if ($this->id === null) {
            $this->insert();
        } else {
            $this->update();
        }

        return $this;
    }

    public static function create(
        string $name,
        string $originalName,
        string $homepage,
        string $overview,
        ?int $posterId,
        ?int $id = null
    ): TVShow {
        $tvShow = new TVShow();
        $tvShow->setId($id)->setName($name)
            ->setOriginalName($originalName)->setHomepage($homepage)
            ->setOverview($overview)->setPosterId($posterId);

        return $tvShow;
    }

    public static function findById(int $id): TVShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT * 
            FROM tvshow
            WHERE id = ?
            SQL
        );

        $stmt->execute([$id]);

        $tvShow = $stmt->fetchObject(self::class);

        if ($tvShow === false) {
            throw new EntityNotFoundException("Il n'existe aucune série TV avec l'identifiant $id.");
        }

        return $tvShow;
    }
}
