<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    /**
     * Escape special characters that could degrade the web page.
     * @param string|null $string The string to escape.
     * @return string The escaped string.
     */
    public function escapeString(?string $string): string
    {
        $result = '';

        if(!is_null($string)) {
            $result = htmlspecialchars($string, ENT_QUOTES | ENT_HTML5);
        }

        return $result;
    }

    /**
     * Remove HTML and PHP tags from a string and trim it.
     * @param string|null $string The string to process.
     * @return string The processed string.
     */
    public function stripTagsAndTrim(?string $string): string
    {
        $result = '';

        if(!is_null($string)) {
            $result = strip_tags(trim($string));
        }

        return $result;
    }
}
