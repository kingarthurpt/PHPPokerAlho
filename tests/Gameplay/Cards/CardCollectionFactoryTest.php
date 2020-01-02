<?php

namespace Tests\Gameplay\Cards;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Cards\StandardCard;
use TexasHoldemBundle\Gameplay\Cards\StandardSuit;

class CardCollectionFactoryTest extends \Tests\BaseTestCase
{
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new CardCollectionFactory();
    }

    public function testMakeFromString()
    {
        $string = 'As Kh';
        $aceSpaces = new StandardCard(14, new StandardSuit('Spades', '♠', 's'));
        $kingHearts = new StandardCard(13, new StandardSuit('Hearts', '♥', 'h'));

        $collection = new CardCollection([$aceSpaces, $kingHearts]);

        $this->assertEquals(
            $collection,
            $this->factory->makeFromString($string)
        );

        $string = 'Ass';
        $this->assertNull($this->factory->makeFromString($string));
    }
}
