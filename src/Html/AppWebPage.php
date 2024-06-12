<?php

declare(strict_types=1);

namespace Html;

use Html\WebPage;

class AppWebPage extends WebPage
{
    private string $menu;

    public function __construct(string $title = '')
    {
        parent::__construct($title);
        $this->menu = '';

        $this->appendCssUrl('/css/style.css');
        $this->appendToMenu(
            <<<HTML
            <a href="/">Accueil</a>
            HTML
        );
    }

    public function getMenu(): string
    {
        return $this->menu;
    }

    /**
     * Add content to the menu.
     * @param string $menu The content to add.
     */
    public function appendToMenu(string $menu): void
    {
        $this->menu .= $menu;
    }

    /**
     * Return and generate the HTML structure of the page.
     * @return string The HTML structure of the page.
     */
    public function toHTML(): string
    {
        $lastModif = self::getLastModification();
        return <<<HTML
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta charset="UTF-8">
                <meta name="description" content="Site Web de consultation et d'édition de séries TVs.">
                <link rel="icon" href="favicon.ico" type="image/x-icon">
                <title>{$this->getTitle()}</title>
                {$this->getHead()}
            </head>
            <body>
                <header class="header">
                    <h1>{$this->getTitle()}</h1>
                </header>
                <nav class="menu">
                {$this->getMenu()}
                </nav>
                <main class="content">
                    {$this->getBody()}
                </main>
                <footer class="footer">
                    <p>Dernière modification : $lastModif</p>
                </footer>
            </body>
            </html>
            HTML;
    }
}
