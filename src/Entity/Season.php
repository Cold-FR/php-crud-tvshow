<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Collection\EpisodeCollection;
use Entity\Exception\EntityNotFoundException;

class Season
{
    private int $id;
    private int $tvShowId;
    private string $name;
    private int $seasonNumber;
    private ?int $posterId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTvShowId(): int
    {
        return $this->tvShowId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }

    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /**
     * Find a season by its ID.
     * @param int $id The ID of the season.
     * @return Season The season instance.
     * @throws EntityNotFoundException If no season is found with the given ID.
     */
    public static function findById(int $id): Season
    {
        $stmtSeason = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, tvShowId, name, seasonNumber, posterId
            FROM season
            WHERE id = :id 
            SQL
        );
        $stmtSeason->execute(['id' => $id]);

        $season = $stmtSeason->fetchObject(Season::class);
        if ($season === false) {
            throw new EntityNotFoundException("Il n'existe aucune saison avec l'identifiant $id.");
        }

        return $season;
    }

    /**
     * Get the episodes of the season.
     * @return array<Episode> The episodes of the season.
     */
    public function getEpisodes(): array
    {
        return EpisodeCollection::findBySeasonId($this->id);
    }

    /**
     * Get the TV show of the season.
     * @return TVShow The TV show instance.
     */
    public function getTvShow(): TVShow
    {
        return TVShow::findById($this->tvShowId);
    }
}
