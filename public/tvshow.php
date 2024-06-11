<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\TVShow;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if(empty($_GET['tvShowId']) || !is_numeric($_GET['tvShowId'])) {
        throw new ParameterException("L'identifiant entré pour la série est invalide.");
    }

    $appWebPage = new AppWebPage();
    $tvShowId = (int) $_GET['tvShowId'];

    $tvShow = TVShow::findById($tvShowId);
    $tvShowName = $appWebPage->escapeString($tvShow->getName());
    $appWebPage->setTitle("Séries TV : {$tvShowName}");

    $seasons = $tvShow->getSeasons();

    $appWebPage->appendContent(<<<HTML
        <div class="list-element head-page">
                <img class="img-poster" src='poster.php?posterId={$tvShow->getPosterId()}' alt="Affiche de $tvShowName">
                <div class="list-element-info">
                    <h3 class="list-element-title">
                        $tvShowName
                    </h3>
                    <h3 class="list-element-title">
                        {$appWebPage->escapeString($tvShow->getOriginalName())}
                    </h3>
                    <p class="list-element-overview">
                        {$appWebPage->escapeString($tvShow->getOverview())}
                    </p>
                </div>
        </div>
        HTML);

    $appWebPage->appendContent('<ul class="list seasons">');
    foreach ($seasons as $season) {
        $seasonName = $appWebPage->escapeString($season->getName());
        $appWebPage->appendContent(<<<HTML
            <li class="list-element">
                <img class="img-poster" src='poster.php?posterId={$season->getPosterId()}' alt="Affiche de $seasonName">
                <div class="list-element-info">
                    <h4 class="list-element-title">
                    <a href="season.php?seasonId={$season->getId()}">
                        $seasonName
                    </a>
                    </h4>
                </div>   
            </li>
            HTML);
    }
    $appWebPage->appendContent('</ul>');

    echo $appWebPage->toHTML();
} catch (ParameterException|EntityNotFoundException) {
    header('Location: index.php');
} catch (Exception) {
    http_response_code(500);
}
