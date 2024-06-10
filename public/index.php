<?php
declare(strict_types=1);

use Entity\TVShow;
use Entity\Collection\TVShowCollection;
use Entity\Exception\EntityNotFoundException;
use Html\WebPage;

try {
    $webPage = new WebPage("Séries TV");

    $tvShows = TVShowCollection::findAll();

    foreach ($tvShows as $index => $tvShow) {
        $webPage->appendContent("<a><div>{$webPage->escapeString($tvShow->getName())}{$tvShow->getOverview()}</div></a>");
    }


    echo $webPage->toHTML();

} catch (EntityNotFoundException){
    http_response_code(404);

} catch (Exception) {
    http_response_code(500);

}



