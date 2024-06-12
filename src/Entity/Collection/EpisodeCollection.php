<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Episode;
use PDO;

class EpisodeCollection
{
    /**
     * Find episodes by season ID.
     * @param int $seasonId The ID of the season.
     * @return array<Episode> An array of Episode instances.
     */
    public static function findBySeasonId(int $seasonId): array
    {
        $stmtEpisode = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, seasonId, name, overview, episodeNumber
            FROM episode
            WHERE seasonId = :id
            SQL
        );
        $stmtEpisode->execute(['id' => $seasonId]);

        return $stmtEpisode->fetchAll(PDO::FETCH_CLASS, Episode::class);
    }
}
