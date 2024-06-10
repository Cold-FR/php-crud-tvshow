<?php
declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Episode;
use PDO;

class EpisodeCollection
{
    public static function findBySeasonId(int $seasonId): array
    {
        $stmtEpisode = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM episode
            WHERE seasonId=:id
            SQL
        );
        $stmtEpisode->execute(['id' => $seasonId]);
        return $stmtEpisode->fetchAll(PDO::FETCH_CLASS, Episode::class);
    }
}