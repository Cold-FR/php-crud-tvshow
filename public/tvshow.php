<?php

declare(strict_types=1);

use Entity\TVShow;
use Html\AppWebPage;

try {
    if(empty($_GET['tvShowId']) || !is_numeric($_GET['tvShowId'])) {
        header('Location: index.php');
        exit;
    }
    $AppWebPage = new AppWebPage();
    $tvShowId = (int) $_GET['tvShowId'];

    $tvShow = TVShow::findById($tvShowId);
    $seasons = $tvShow->getSeasons();

    $AppWebPage->appendContent("<img src='poster.php?posterId={$tvShow->getPosterId()}'> <div>{$tvShow->getName()}{$tvShow->getOriginalName()}{$tvShow->getOverview()}");
    foreach ($seasons as $season) {
        $name = $AppWebPage->escapeString($season->getName());
        $AppWebPage->appendContent("<img src='poster.php?posterId={$season->getPosterId()}'><div>$name</div>\n");

    }

    echo $AppWebPage->toHTML();
} catch (ParameterException) {
    header('Location: index.php'); 
} catch (Exception) {
    http_response_code(500);
}
