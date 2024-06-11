<?php

declare(strict_types=1);

use Entity\TVShow;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if(empty($_GET['tvShowId']) || !ctype_digit($_GET['tvShowId'])) {
        throw new ParameterException("L'identifiant de la série TV est invalide.");
    }

    $tvShowId = (int) $_GET['tvShowId'];

    $tvShow = TVShow::findById($tvShowId);

    $tvShow->delete();

    header('Location: /');
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
