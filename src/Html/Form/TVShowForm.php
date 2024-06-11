<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\TVShow;
use Exception\ParameterException;
use Html\StringEscaper;

class TVShowForm
{
    use StringEscaper;

    private ?TVShow $tvShow;

    public function __construct(?TVShow $tvShow = null)
    {
        $this->tvShow = $tvShow;
    }

    public function getTVShow(): ?TVShow
    {
        return $this->tvShow;
    }

    public function getHtmlForm(string $action): string
    {
        $showName = $this?->getTVShow()?->getName();
        $showOriginalName = $this?->getTVShow()?->getOriginalName();
        $showHomepage = $this?->getTVShow()?->getHomepage();
        $showOverview = $this?->getTVShow()?->getOverview();
        return <<<HTML
            <form action="$action" method="post">
                <input type="hidden" name="id" 
                        value="{$this?->getTVShow()?->getId()}"/>
                <label>
                    Nom
                    <input type="text" name="name" 
                        value="{$this->escapeString($showName)}" required/>
                </label>
                <label>
                    Nom original
                    <input type="text" name="originalName" 
                        value="{$this->escapeString($showOriginalName)}" required/>
                </label>
                <label>
                    Homepage
                    <input type="text" name="homepage" 
                        value="{$this->escapeString($showHomepage)}" required/>
                </label>
                <label>
                    Description
                    <input type="text" name="overview" 
                        value="{$this->escapeString($showOverview)}" required/>
                </label>
                <label>
                    Identifiant de l'affiche
                    <input type="number" name="posterId" 
                        value="{$this?->getTVShow()?->getPosterId()}"/>
                </label>
                <input type="submit" value="Enregistrer"/>
            </form>
        HTML;
    }

    public function setEntityFromQueryString(): void
    {
        $tvShowId = null;
        if (!empty($_POST['id']) && ctype_digit($_POST['id'])) {
            $tvShowId = (int) $_POST['id'];
        }

        if (empty($_POST['name']) || empty($_POST['originalName']) || empty($_POST['homepage'])
            || empty($_POST['overview'])) {
            throw new ParameterException("Un des champs n'a pas été complété.");
        }

        $this->tvShow = TVShow::create(
            $this->stripTagsAndTrim($_POST['name']),
            $this->stripTagsAndTrim($_POST['originalName']),
            $this->stripTagsAndTrim($_POST['homepage']),
            $this->stripTagsAndTrim($_POST['overview']),
            empty($_POST['posterId']) ? null : (int) $_POST['posterId'],
            $tvShowId
        );
    }
}
