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
     * Constructeur.
     * @param string $title Titre de la page.
     */
    public function __construct(string $title = '')
    {
        $this->head = '';
        $this->title = $title;
        $this->body = '';
    }

    /**
     * Retourne le contenu de $this→head.
     * @return string Le contenu de $this→head.
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Retourne le contenu de $this→title.
     * @return string Le contenu de $this→title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Affecter le titre de la page.
     * @param string $title Le titre.
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     *  Retourne le contenu de $this→body.
     * @return string Le contenu de $this→body.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Ajouter un contenu dans $this→head.
     * @param string $content Le contenu à ajouter.
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Ajouter un contenu CSS dans $this→head.
     * @param string $css Le contenu CSS à ajouter.
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead("<style>$css</style>");
    }

    /**
     * Ajouter l'URL d'un script CSS dans $this→head.
     * @param string $url L'URL du script CSS.
     * @return void
     */
    public function appendCssUrl(string $url): void
    {
        $this->appendToHead('<link type="text/css" rel="stylesheet" href="' . $url . '">');
    }

    /**
     * Ajouter un contenu JavaScript dans $this→head.
     * @param string $js Le contenu JavaScript à ajouter.
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->appendContent("<script type='text/javascript'>$js</script>");
    }

    /**
     * Ajouter l'URL d'un script JavaScript dans $this→head.
     * @param string $url L'URL du script JavaScript.
     * @return void
     */
    public function appendJsUrl(string $url): void
    {
        $this->appendContent('<script type="text/javascript" src="' . $url . '"></script>');
    }

    /**
     * Ajouter un contenu dans $this→body.
     * @param string $content Le contenu à ajouter.
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Produire la page Web complète.
     * @return string La page Web complète.
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
     * Donner la date et l'heure de la dernière modification du script principal.
     * @return string La date et l'heure de la dernière modification.
     */
    public static function getLastModification(): string
    {
        return date('d/m/Y H:i:s', getlastmod());
    }
}
