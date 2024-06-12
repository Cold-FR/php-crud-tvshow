<?php

namespace Tests\Crud;

use Entity\Cover;
use Entity\Exception\EntityNotFoundException;
use Entity\Poster;
use Tests\CrudTester;

class PosterCest
{
    public function findById(CrudTester $I): void
    {
        $poster = Poster::findById(19);
        $I->assertSame(19, $poster->getId());
        $I->assertSame(file_get_contents(codecept_data_dir().'/poster/poster19.jpeg'), $poster->getJpeg());
    }

    public function findByIdThrowsExceptionIfPosterDoesNotExist(CrudTester $I): void
    {
        $I->expectThrowable(EntityNotFoundException::class, function () {
            Poster::findById(PHP_INT_MAX);
        });
    }
}
