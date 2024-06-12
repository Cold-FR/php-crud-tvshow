<?php

namespace Tests\Browse;

use Codeception\Example;
use Tests\BrowseTester;

class TVShowCest
{
    public function checkAppWebPageHtmlStructure(BrowseTester $I)
    {
        $I->amOnPage('/tvshow.php?tvShowId=70');
        $I->seeResponseCodeIs(200);
        $I->seeElement('.header');
        $I->seeElement('.header h1');
        $I->seeElement('.content');
        $I->seeElement('.footer');
    }

    public function loadShowPageWithoutParameter(BrowseTester $I)
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('/tvshow.php');
        $I->seeResponseCodeIsRedirection();
        $I->followRedirect();
        $I->seeInCurrentUrl('/index.php');
    }

    /**
     * @dataProvider wrongParameterProvider
     */
    public function loadShowPageWithWrongParameter(BrowseTester $I, Example $example)
    {
        $I->stopFollowingRedirects();
        $I->amOnPage('/tvshow.php?tvShowId='.$example['id']);
        $I->seeResponseCodeIsRedirection();
        $I->followRedirect();
        $I->seeInCurrentUrl('/index.php');
    }

    protected function wrongParameterProvider(): array
    {
        return [
            ['id' => ''],
            ['id' => 'bad_id_value'],
        ];
    }

    public function loadShowPageWithUnknownShowId(BrowseTester $I)
    {
        $I->amOnPage('/tvshow.php?tvShowId='.PHP_INT_MAX);
        $I->seeResponseCodeIs(404);
    }

    public function loadArtistAndAlbumsWithCorrectParameter(BrowseTester $I)
    {
        $I->amOnPage('/tvshow.php?tvShowId=70');
        $I->seeResponseCodeIs(200);
        $I->seeInTitle('Séries TV : Hunters', '.header h1');
        $I->see('Séries TV : Hunters', '.header h1');
        $I->assertCount(
            1,
            $I->grabMultiple('.content .list li')
        );
    }
}
