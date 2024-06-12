<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    use StringEscaper;

    private string $head;

    private string $title;

    private string $body;

    /**
     * Constructor.
     * @param string $title Title of the page.
     */
    public function __construct(string $title = '')
    {
        $this->head = '';
        $this->title = $title;
        $this->body = '';
    }

    public function getHead(): string
    {
        return $this->head;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Append content to the head of the page.
     * @param string $content The content to append.
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Append CSS to the head of the page.
     * @param string $css The CSS to append.
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead("<style>$css</style>");
    }

    /**
     * Append a CSS URL to the head of the page.
     * @param string $url The URL to append.
     */
    public function appendCssUrl(string $url): void
    {
        $this->appendToHead('<link type="text/css" rel="stylesheet" href="' . $url . '">');
    }

    /**
     * Append JavaScript to the head of the page.
     * @param string $js The JavaScript to append.
     */
    public function appendJs(string $js): void
    {
        $this->appendContent("<script type='text/javascript'>$js</script>");
    }

    /**
     * Append a JavaScript URL to the head of the page.
     * @param string $url The URL to append.
     */
    public function appendJsUrl(string $url): void
    {
        $this->appendContent('<script type="text/javascript" src="' . $url . '"></script>');
    }

    /**
     * Append content to the body of the page.
     * @param string $content The content to append.
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Generate the complete web page.
     * @return string The complete web page.
     */
    public function toHTML(): string
    {
        return <<<HTML
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta charset="UTF-8">
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
                {$this->getBody()}
            </body>
            </html>
            HTML;
    }

    /**
     * Get the date and time of the last modification of the main script.
     * @return string The date and time of the last modification.
     */
    public static function getLastModification(): string
    {
        return date('d/m/Y H:i:s', getlastmod());
    }
}
