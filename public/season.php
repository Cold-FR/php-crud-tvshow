<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Season;
use Entity\TVShow;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    if (empty($_GET['seasonId']) || !ctype_digit($_GET['seasonId'])) {
        throw new ParameterException("L'identifiant entré pour la saison est invalide.");
    }

    $appWebPage = new AppWebPage();
    $appWebPage->appendCssUrl('/css/season.css');

    $seasonId = (int) $_GET['seasonId'];
    $season = Season::findById($seasonId);
    $seasonName = $appWebPage->escapeString($season->getName());

    $tvShow = $season->getTvShow();
    $tvShowName = $appWebPage->escapeString($tvShow->getName());
    $tvShowHomepage = $appWebPage->escapeString($tvShow->getHomepage());

    $appWebPage->setTitle("Séries TV : {$tvShowName} - {$seasonName}");

    $episodes = $season->getEpisodes();


    $appWebPage->appendContent(
        <<<HTML
        <div class="list-element head-page">
                <img class="img-poster" src='poster.php?posterId={$season->getPosterId()}' alt="Affiche de $seasonName">
                <div class="list-element-info">
                    <h2 class="list-element-title">
                        <a href="tvshow.php?tvShowId={$season->getTvShowId()}">
                            $tvShowName
                        </a>
                    </h2>
                    <h2 class="list-element-title">
                        $seasonName
                    </h2>
                </div>
        </div>
        HTML
    );

    $appWebPage->appendContent('<ul class="list episodes">');
    foreach ($episodes as $episode) {
        $episodeName = $appWebPage->escapeString($episode->getName());
        $episodeOverview = $appWebPage->escapeString($episode->getOverview());
        $appWebPage->appendContent(
            <<<HTML
            <div class="list-element">
                <div class="list-element-info">
                    <div class="list-episode-head">
                        <h3 class="list-element-title">
                            Épisode {$episode->getEpisodeNumber()}
                        </h3>
                        <h3 class="list-element-title">
                            $episodeName
                        </h3>
                    </div>
                    <p class="list-element-overview">
                        $episodeOverview
                    </p>
                </div>   
            </div>
            HTML
        );
    }
    $appWebPage->appendContent('</ul>');

    echo $appWebPage->toHTML();
} catch (ParameterException|EntityNotFoundException) {
    header('Location: index.php', response_code: 302);
} catch (Exception) {
    http_response_code(500);
}
