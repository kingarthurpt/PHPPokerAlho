<?php

namespace Tests;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Cards\StandardSuit;

class CardCollectionFactoryTest extends BaseTestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new CardCollectionFactory();
    }

    public function testMakeFromString()
    {
        $cards = "As Ks";

        $result = $this->factory->makeFromString($cards);
        $this->assertInstanceOf(CardCollection::class, $result);
        $this->assertSame("A", $result->getCardAt(0)->getFaceValue());
        $this->assertSame("s", $result->getCardAt(0)->getSuit()->getAbbreviation());
        $this->assertSame("K", $result->getCardAt(1)->getFaceValue());
        $this->assertSame("s", $result->getCardAt(1)->getSuit()->getAbbreviation());
    }

    public function testMakeFromInvalidString()
    {
        $cards = "Ass";
        $result = $this->factory->makeFromString($cards);
        $this->assertNull($result);
    }
}
