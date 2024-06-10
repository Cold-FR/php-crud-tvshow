<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Poster;
use Exception\ParameterException;

try {
    if (empty($_GET['posterId']) || !ctype_digit($_GET['posterId'])) {
        throw new ParameterException("L'identifiant entré pour l'affiche est invalide.");
    }

    header('Content-Type: image/jpeg');

    $posterId = (int) $_GET['posterId'];

    $posterData = Poster::findById($posterId);

    echo $posterData->getJpeg();
} catch (ParameterException|EntityNotFoundException) {
    header('Location: /img/default.png');
} catch (Exception) {
    http_response_code(500);
}
