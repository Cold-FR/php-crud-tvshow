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

    /**
     * Get the seasons of the TV show.
     * @return array<Season> The seasons of the TV show.
     */
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

    /**
     * Delete the TV show from the database.
     * @return TVShow The TV show instance.
     */
    public function delete(): TVShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            DELETE
            FROM tvshow
            WHERE id = :id
            SQL
        );
        $stmt->execute(['id' => $this->id]);

        $this->id = null;

        return $this;
    }

    /**
     * Update the TV show in the database.
     * @return TVShow The TV show instance.
     */
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

    /**
     * Insert the TV show into the database.
     * @return TVShow The TV show instance.
     */
    public function insert(): TVShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            INSERT INTO
            tvshow(name,originalName,homepage,overview,posterId)
            VALUES(:name,:originalName,:homepage,:overview,:posterId)
            SQL
        );

        $stmt->execute([
            'name' => $this->name,
            'originalName' => $this->originalName,
            'homepage' => $this->homepage,
            'overview' => $this->overview,
            'posterId' => $this->posterId
        ]);

        $lastId = (int) MyPdo::getInstance()->lastInsertId();

        return $this->setId($lastId);
    }

    /**
     * Save the TV show to the database.
     * If the TV show does not have an ID, it is inserted. Otherwise, it is updated.
     * @return TVShow The TV show instance.
     */
    public function save(): TVShow
    {
        if ($this->id === null) {
            $this->insert();
        } else {
            $this->update();
        }

        return $this;
    }

    /**
     * Create a new TV show instance.
     * @param string $name The name of the TV show.
     * @param string $originalName The original name of the TV show.
     * @param string $homepage The homepage of the TV show.
     * @param string $overview The overview of the TV show.
     * @param int|null $posterId The poster ID of the TV show.
     * @param int|null $id The ID of the TV show.
     * @return TVShow The TV show instance.
     */
    public static function create(
        string $name,
        string $originalName,
        string $homepage,
        string $overview,
        ?int $posterId,
        ?int $id = null
    ): TVShow {
        $tvShow = new TVShow();
        $tvShow->setId($id)
            ->setName($name)
            ->setOriginalName($originalName)
            ->setHomepage($homepage)
            ->setOverview($overview)
            ->setPosterId($posterId);

        return $tvShow;
    }

    /**
     * Find a TV show by its ID.
     * @param int $id The ID of the TV show.
     * @return TVShow The TV show instance.
     * @throws EntityNotFoundException If no TV show is found with the given ID.
     */
    public static function findById(int $id): TVShow
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT id, name, originalName, homepage, overview, posterId
            FROM tvshow
            WHERE id = :id
            SQL
        );

        $stmt->execute(['id' => $id]);

        $tvShow = $stmt->fetchObject(self::class);

        if ($tvShow === false) {
            throw new EntityNotFoundException("Il n'existe aucune série TV avec l'identifiant $id.");
        }

        return $tvShow;
    }
}
