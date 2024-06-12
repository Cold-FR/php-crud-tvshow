<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Poster
{
    private int $id;
    private string $jpeg;

    public function getId(): int
    {
        return $this->id;
    }

    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    public static function findById(int $id): Poster
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT id, jpeg
            FROM poster
            WHERE id = :id
            SQL
        );
        $stmt ->execute(['id' => $id]);

        $poster = $stmt->fetchObject(self::class);

        if ($poster === false) {
            throw new EntityNotFoundException("Il n'existe aucune affiche avec l'identifiant $id.");
        }

        return $poster;
    }
}
