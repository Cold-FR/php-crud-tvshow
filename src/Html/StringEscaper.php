<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    /**
     * Protéger les caractères spéciaux pouvant dégrader la page Web.
     * @param string|null $string $string La chaîne à protéger.
     * @return string La chaîne protégée.
     */
    public function escapeString(?string $string): string
    {
        $result = '';

        if(!is_null($string)) {
            $result = htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
        }

        return $result;
    }

    public function stripTagsAndTrim(?string $string): string
    {
        $result = '';

        if(!is_null($string)) {
            $result = strip_tags(trim($string));
        }

        return $result;
    }
}
