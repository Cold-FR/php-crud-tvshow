<?php

namespace Tests\Crud\Collection;

use Entity\Collection\TVShowCollection;
use Entity\TVShow;
use Tests\CrudTester;

class TVShowCollectionCest
{
    public function findAll(CrudTester $I): void
    {
        $expectedShows = [
            ['id' => 3, 'name' => 'Friends'],
            ['id' => 25, 'name' => 'Futurama'],
            ['id' => 57, 'name' => 'Good Omens'],
            ['id' => 70, 'name' => 'Hunters'],
            ['id' => 40, 'name' => 'La caravane de l\'étrange']
        ];

        $shows = TVShowCollection::findAll();
        $I->assertCount(count($expectedShows), $shows);
        $I->assertContainsOnlyInstancesOf(TVShow::class, $shows);
        foreach ($shows as $index => $show) {
            $expectedShow = $expectedShows[$index];
            $I->assertEquals($expectedShow['id'], $show->getId());
            $I->assertEquals($expectedShow['name'], $show->getName());
        }
    }
}
