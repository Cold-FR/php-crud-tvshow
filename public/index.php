<?php

declare(strict_types=1);

use Entity\Collection\TVShowCollection;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;

try {
    $webPage = new AppWebPage("Séries TV");

    $tvShows = TVShowCollection::findAll();

    $webPage->appendContent('<ul class="list">');

    foreach ($tvShows as $tvShow) {
        $webPage->appendContent(
            <<<HTML
            <a href="tvshow.php?tvShowId={$tvShow->getId()}" class="list-element">
                <img class="img-poster" src='poster.php?posterId={$tvShow->getPosterId()}' alt="Affiche de {$tvShow->getName()}">
                <div class="list-element-info">
                    <h3 class="list-element-title">
                        {$webPage->escapeString($tvShow->getName())}
                    </h3>
                    <p class="list-element-overview">
                        {$webPage->escapeString($tvShow->getOverview())}
                    </p>
                </div>
            </a>
            HTML
        );
    }

    $webPage->appendContent('</ul>');

    echo $webPage->toHTML();
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
