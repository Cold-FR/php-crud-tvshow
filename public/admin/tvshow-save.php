<?php

declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\TVShowForm;

try {
    $tvShowForm = new TVShowForm();
    $tvShowForm->setEntityFromQueryString();
    $tvShowForm->getTVShow()->save();

    header('Location: /');
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception $e) {
    echo $e->getMessage();
    http_response_code(500);
}
