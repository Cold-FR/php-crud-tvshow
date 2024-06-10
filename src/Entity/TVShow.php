<?php

declare(strict_types=1);

namespace Entity;

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
}
