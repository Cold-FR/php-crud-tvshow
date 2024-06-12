<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Season;
use PDO;

class SeasonCollection
{
    public static function findByTvShowId(int $tvShowId): array
    {
        $stmtSeason = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, tvShowId, name, seasonNumber, posterId
            FROM season
            WHERE tvShowId=:id
            ORDER BY seasonNumber
            SQL
        );
        $stmtSeason->execute(['id' => $tvShowId]);

        return $stmtSeason->fetchAll(PDO::FETCH_CLASS, Season::class);
    }
}
