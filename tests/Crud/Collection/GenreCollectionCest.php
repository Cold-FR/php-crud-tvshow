<?php
namespace Tests\Crud\Collection;
use Entity\Collection\GenreCollection;
use Entity\Genre;
use Tests\CrudTester;
class GenreCollectionCest
{
    public function findAll(CrudTester $I): void
    {
        $expectedGenres = [
            ['id' => 1, 'name' => 'Action & Adventure'],
            ['id' => 2, 'name' => 'Crime'],
            ['id' => 3, 'name' => 'Drame'],
            ['id' => 4, 'name' => 'Comédie'],
            ['id' => 5, 'name' => 'Science-Fiction & Fantastique'],
            ['id' => 6, 'name' => 'Mystère'],
            ['id' => 7, 'name' => 'Western'],
            ['id' => 8, 'name' => 'War & Politics'],
            ['id' => 9, 'name' => 'Familial'],
            ['id' => 10, 'name' => 'Animation'],
            ['id' => 11, 'name' => 'Romance'],
        ];

        $genres = GenreCollection::findAll();
        $I->assertCount(count($expectedGenres), $genres);
        $I->assertContainsOnlyInstancesOf(Genre::class, $genres);
        foreach ($genres as $index => $genre) {
            $expectedGenre = $expectedGenres[$index];
            $I->assertEquals($expectedGenre['id'], $genre->getId());
            $I->assertEquals($expectedGenre['name'], $genre->getName());
        }
    }
}
