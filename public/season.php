<?php

declare(strict_types=1);


use Entity\Season;
use Entity\TVShow;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if (empty($_GET['seasonId']) || !is_numeric($_GET['seasonId'])) {
        throw new ParameterException("L'identifiant entré pour la saison est invalide.");
    }

    $appWebPage = new AppWebPage();
    $seasonId = (int)$_GET['seasonId'];

    $season = Season::findById($seasonId);
    $seasonName = $appWebPage->escapeString($season->getName());
    $appWebPage->setTitle("Séries TV : {$seasonName}");

    $episodes = $season->getEpisodes();
    $tvShow = TVShow::findById($season->getTvShowId());

    $appWebPage->appendContent(
        <<<HTML
        <div class="list-element head-page">
                <img class="img-poster" src='poster.php?posterId={$season->getPosterId()}' alt="Affiche de $seasonName">
                <div class="list-element-info">
                    <h3 class="list-element-title">
                        {$tvShow->getName()}
                    </h3>
                    <h3 class="list-element-title">
                        $seasonName
                    </h3>
                </div>
        </div>
        HTML
    );

    $appWebPage->appendContent('<ul class="list seasons">');
    foreach ($episodes as $episode) {
        $episodeName = $appWebPage->escapeString($episode->getName());
        $episodeOverview = $appWebPage->escapeString($episode->getOverview());
        $appWebPage->appendContent(
            <<<HTML
            <div class="list-element">
                <div class="list-element-info">
                    <h4 class="list-element-title">
                    $episodeName
                    {$episode->getEpisodeNumber()}
                    $episodeOverview
                    </h4>
                </div>   
            </div>
            HTML
        );
    }
    $appWebPage->appendContent('</ul>');

    echo $appWebPage->toHTML();
} catch (ParameterException) {
    header('Location: index.php');
} catch (Exception) {
    http_response_code(500);
}
