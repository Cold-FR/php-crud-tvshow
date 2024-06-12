<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Genre
{
    private int $id;
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function findById(int $id): Genre
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name
            FROM genre
            WHERE id = :id
            SQL
        );
        $stmt->execute(['id' => $id]);

        $genre = $stmt->fetchObject(self::class);

        if ($genre === false) {
            throw new EntityNotFoundException("Il n'existe aucun genre avec l'identifiant $id.");
        }

        return $genre;
    }
}
