<?php

namespace Tests\Gameplay\Cards;

use TexasHoldemBundle\Gameplay\Cards\StandardSuit;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;

class StandardSuitFactoryTest extends \Tests\BaseTestCase
{
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new StandardSuitFactory();
    }

    public function testMake()
    {
        $this->assertEquals(
            new StandardSuit('Clubs', '♣', 'c'),
            $this->factory->make(StandardSuit::CLUBS)
        );
        $this->assertEquals(
            new StandardSuit('Diamonds', '♦', 'd'),
            $this->factory->make(StandardSuit::DIAMONDS)
        );
        $this->assertEquals(
            new StandardSuit('Hearts', '♥', 'h'),
            $this->factory->make(StandardSuit::HEARTS)
        );
        $this->assertEquals(
            new StandardSuit('Spades', '♠', 's'),
            $this->factory->make(StandardSuit::SPADES)
        );
        $this->assertNull($this->factory->make([]));
    }

    public function testMakeFromAbbr()
    {
        $this->assertEquals(
            new StandardSuit('Clubs', '♣', 'c'),
            $this->factory->makeFromAbbr('c')
        );
        $this->assertEquals(
            new StandardSuit('Diamonds', '♦', 'd'),
            $this->factory->makeFromAbbr('d')
        );
        $this->assertEquals(
            new StandardSuit('Hearts', '♥', 'h'),
            $this->factory->makeFromAbbr('h')
        );
        $this->assertEquals(
            new StandardSuit('Spades', '♠', 's'),
            $this->factory->makeFromAbbr('s')
        );
        $this->assertNull($this->factory->makeFromAbbr('a'));
    }
}
