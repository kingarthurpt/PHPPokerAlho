<?php

namespace Tests\Gameplay\Cards;

use TexasHoldemBundle\Gameplay\Cards\StandardCardFactory;
use TexasHoldemBundle\Gameplay\Cards\StandardCard;
use TexasHoldemBundle\Gameplay\Cards\StandardSuit;
use TexasHoldemBundle\Gameplay\Cards\Suit;

class StandardCardFactoryTest extends \Tests\BaseTestCase
{
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new StandardCardFactory();
    }

    public function testMake()
    {
        $hearts = StandardSuit::HEARTS;
        $suit = new StandardSuit($hearts[0], $hearts[1], $hearts[2]);
        $result = $this->factory->make('13', $suit);

        $expectedCard = new StandardCard('13', $suit);
        $this->assertEquals($expectedCard, $result);
    }

    public function testMakeFromString()
    {
        $string = 'Kh';
        $result = $this->factory->makeFromString($string);

        $hearts = StandardSuit::HEARTS;
        $suit = new StandardSuit($hearts[0], $hearts[1], $hearts[2]);
        $expectedCard = new StandardCard('13', $suit);
        $this->assertEquals($expectedCard, $result);

        $string = 'Khs';
        $this->assertNull($this->factory->makeFromString($string));
    }
}
