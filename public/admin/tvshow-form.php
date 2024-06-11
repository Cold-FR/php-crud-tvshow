<?php

declare(strict_types=1);

use Entity\TVShow;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\AppWebPage;
use Html\Form\TVShowForm;

try {
    $tvShow = null;
    if (isset($_GET['tvShowId'])) {
        if(empty($_GET['tvShowId']) || !ctype_digit($_GET['tvShowId'])) {
            throw new ParameterException("L'identifiant de la série TV est invalide.");
        }

        $tvShowId = (int) $_GET['tvShowId'];

        $tvShow = TVShow::findById($tvShowId);
    }

    $tvShowForm = new TVShowForm($tvShow);

    $appWebPage = new AppWebPage("Formulaire Série TV");
    $appWebPage->appendCssUrl('/css/form.css');
    $appWebPage->appendContentMenu(
        <<<HTML
        <a href="/">Retourner à l'accueil</a>
        HTML
    );
    $appWebPage->appendContent($tvShowForm->getHtmlForm('tvshow-save.php'));

    echo $appWebPage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}