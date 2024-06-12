<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use Entity\TVShow;
use PDO;

class TVShowCollection
{
    /**
     * Find all TV shows.
     * @return array<TVShow> An array of TV show instances.
     */
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name, originalName, homepage, overview, posterId
            FROM tvshow
            ORDER BY name
            SQL
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, TVShow::class);
    }

    /**
     * Find TV shows by genre ID.
     * @param int $genreId The ID of the genre.
     * @return array<TVShow> An array of TV show instances.
     */
    public static function findByGenreId(int $genreId): array
    {
        $genre = Genre::findById($genreId);

        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name, originalName, homepage, overview, posterId
            FROM tvshow
            WHERE id IN (SELECT tvShowId 
                         FROM tvshow_genre
                         WHERE genreId = ?)
            ORDER BY name
            SQL
        );
        $stmt->execute([$genreId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, TVShow::class);
    }
}
