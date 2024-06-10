<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\SeasonCollection;
use Entity\Exception\EntityNotFoundException;

class TVShow
{
    private int $id;
    private string $name;
    private string $originalName;
    private string $overview;
    private int $posterId;

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

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getPosterId(): int
    {
        return $this->posterId;
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

    public function getSeasons(): array
    {
        return SeasonCollection::findByTvShowId($this->id);
    }
}
