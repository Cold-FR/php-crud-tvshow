<?php

declare(strict_types=1);

use Entity\Collection\GenreCollection;
use Entity\Collection\TVShowCollection;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;

try {
    $appWebPage = new AppWebPage("Séries TV");
    $appWebPage->appendCssUrl('/css/index.css');

    $appWebPage->appendToMenu(
        <<<HTML
        <a href="/admin/tvshow-form.php">Ajouter une série TV</a>
        HTML
    );

    $genreId = null;
    if (!empty($_GET['genreId']) && ctype_digit($_GET['genreId'])) {
        $genreId = (int) $_GET['genreId'];
        $tvShows = TVShowCollection::findByGenreId($genreId);
    } else {
        $tvShows = TVShowCollection::findAll();
    }

    $appWebPage->appendContent(
        <<<HTML
        <div class="menu filter-show">
            <a href="/">Tout</a>
        HTML
    );
    foreach (GenreCollection::findAll() as $genre) {
        $appWebPage->appendContent(
            <<<HTML
            <a href="/?genreId={$genre->getId()}">
                {$genre->getName()}
            </a>    
            HTML
        );
    }
    $appWebPage->appendContent('</div>');

    $appWebPage->appendContent('<ul class="list">');
    foreach ($tvShows as $tvShow) {
        $appWebPage->appendContent(
            <<<HTML
            <li>
                <a class="list-element" href="tvshow.php?tvShowId={$tvShow->getId()}">
                    <img class="img-poster" src='poster.php?posterId={$tvShow->getPosterId()}' alt="Affiche de {$tvShow->getName()}">
                    <div class="list-element-info">
                        <h2 class="list-element-title">
                                {$appWebPage->escapeString($tvShow->getName())}
                        </h2>
                        <p class="list-element-overview">
                            {$appWebPage->escapeString($tvShow->getOverview())}
                        </p>
                    </div>
                </a>
            </li>
            HTML
        );
    }
    $appWebPage->appendContent('</ul>');

    echo $appWebPage->toHTML();
} catch (EntityNotFoundException) {
    header('Location: /', response_code: 302);
} catch (Exception) {
    http_response_code(500);
}
