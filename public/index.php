<?php

declare(strict_types=1);

use Entity\Collection\GenreCollection;
use Entity\Collection\TVShowCollection;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;

try {
    $appWebPage = new AppWebPage("Séries TV");

    $genreId = null;
    if (!empty($_GET['showGenre']) && ctype_digit($_GET['showGenre'])) {
        $genreId = (int) $_GET['showGenre'];
    }

    if (is_null($genreId)) {
        $tvShows = TVShowCollection::findAll();
    } else {
        $tvShows = TVShowCollection::findByGenreId($genreId);
    }

    $showGenres = GenreCollection::findAll();
    $appWebPage->appendContent(
        <<<HTML
        <div class="menu filter-show">
            <a href="/">Tout</a>
        HTML
    );
    foreach ($showGenres as $showGenre) {
        $appWebPage->appendContent(
            <<<HTML
            <a href="/?showGenre={$showGenre->getId()}">
                {$showGenre->getName()}
            </a>    
            HTML
        );
    }
    $appWebPage->appendContent('</div>');

    $appWebPage->appendContent('<ul class="list">');
    foreach ($tvShows as $tvShow) {
        $appWebPage->appendContent(
            <<<HTML
            <li class="list-element">
                <img class="img-poster" src='poster.php?posterId={$tvShow->getPosterId()}' alt="Affiche de {$tvShow->getName()}">
                <div class="list-element-info">
                    <h3 class="list-element-title">
                        <a href="tvshow.php?tvShowId={$tvShow->getId()}">
                            {$appWebPage->escapeString($tvShow->getName())}
                        </a>
                    </h3>
                    <p class="list-element-overview">
                        {$appWebPage->escapeString($tvShow->getOverview())}
                    </p>
                </div>
            </li>
            HTML
        );
    }
    $appWebPage->appendContent('</ul>');

    echo $appWebPage->toHTML();
} catch (EntityNotFoundException) {
    header('Location: /');
} catch (Exception) {
    http_response_code(500);
}
