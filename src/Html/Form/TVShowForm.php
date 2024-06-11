<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\TVShow;

class TVShowForm
{

    private ?TVShow $tvShow;

    public function __construct(?TVShow $tvShow = null)
    {
        $this->tvShow = $tvShow;
    }

    public function getTVShow(): ?TVShow
    {
        return $this->tvShow;
    }
}
