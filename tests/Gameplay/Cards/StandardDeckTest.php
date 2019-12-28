<?php

namespace Tests\Gameplay\Cards;

use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;

class StandardDeckTest extends \Tests\BaseTestCase
{
    public function testConstruct()
    {
        $suitFactory = new StandardSuitFactory();
        $deck = new StandardDeck($suitFactory);
        $this->assertNotEquals([], $this->getPropertyValue($deck, 'items'));

        $this->assertEquals(52, $deck->getSize());

        return $deck;
    }
}
