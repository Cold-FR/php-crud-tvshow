<?php
namespace Tests\Crud;
use Entity\Exception\EntityNotFoundException;
use Entity\TVShow;
use Tests\CrudTester;
class TVShowCest
{
    public function findById(CrudTester $I): void
    {
        $show = TVShow::findById(3);
        $I->assertSame(3, $show->getId());
        $I->assertSame('Friends', $show->getName());
    }

    public function findByIdThrowsExceptionIfArtistDoesNotExist(CrudTester $I): void
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            TVShow::findById(PHP_INT_MAX);
        });
    }
}
