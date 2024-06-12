<?php

namespace Tests\Browse;

use Tests\BrowseTester;

class IndexCest
{
    public function checkAppWebPageHtmlStructure(BrowseTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Séries TV');
        $I->seeElement('.header');
        $I->seeElement('.header h1');
        $I->see('Séries TV', '.header h1');
        $I->seeElement('.content');
        $I->seeElement('.footer');
    }

    public function listAllShows(BrowseTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->see('Séries TV', 'h1');
        $I->seeElement('.content .list');
        $I->assertCount(
            5,
            $I->grabMultiple('.content .list a[href]')
        );
    }

    public function clickOnShowLink(BrowseTester $I)
    {
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
        $I->click('Hunters');
        $I->seeInCurrentUrl('/tvshow.php?tvShowId=70');
    }
}
