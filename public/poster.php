<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Entity\Poster;
use Exception\ParameterException;

try {
    if (empty($_GET['posterId']) || !ctype_digit($_GET['posterId'])) {
        throw new ParameterException("L'identifiant entré pour l'affiche est invalide.");
    }

    $posterId = (int) $_GET['posterId'];

    $posterData = Poster::findById($posterId);

    header("Cache-Control: private, max-age=10800, pre-check=10800");
    header("Pragma: private");
    header('Content-Type: image/jpeg');
    echo $posterData->getJpeg();
} catch (ParameterException|EntityNotFoundException) {
    header('Location: /img/default.png', response_code: 302);
} catch (Exception) {
    http_response_code(500);
}
