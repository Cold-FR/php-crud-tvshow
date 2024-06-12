<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\TVShow;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if(empty($_GET['tvShowId']) || !ctype_digit($_GET['tvShowId'])) {
        throw new ParameterException("L'identifiant entré pour la série est invalide.");
    }

    $appWebPage = new AppWebPage();

    $tvShowId = (int) $_GET['tvShowId'];

    $appWebPage->appendToMenu(
        <<<HTML
         <a href="/admin/tvshow-form.php?tvShowId=$tvShowId">Modifier la série TV</a>
         <a href="/admin/tvshow-delete.php?tvShowId=$tvShowId">Supprimer la série TV</a>
        HTML
    );

    $tvShow = TVShow::findById($tvShowId);
    $tvShowName = $appWebPage->escapeString($tvShow->getName());
    $appWebPage->setTitle("Séries TV : {$tvShowName}");

    $seasons = $tvShow->getSeasons();

    $appWebPage->appendContent(<<<HTML
        <div class="list-element head-page">
                <img class="img-poster" src='poster.php?posterId={$tvShow->getPosterId()}' alt="Affiche de $tvShowName">
                <div class="list-element-info">
                    <h2 class="list-element-title">
                        $tvShowName
                    </h2>
                    <h2 class="list-element-title">
                        {$appWebPage->escapeString($tvShow->getOriginalName())}
                    </h2>
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
            <li>
                <a class="list-element" href="season.php?seasonId={$season->getId()}">
                    <img class="img-poster" src='poster.php?posterId={$season->getPosterId()}' alt="Affiche de $seasonName">
                    <div class="list-element-info">
                        <h3 class="list-element-title">
                            $seasonName
                        </h3>
                    </div>   
                </a>
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
