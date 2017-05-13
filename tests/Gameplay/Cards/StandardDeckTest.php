<?php

namespace Tests;

use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardDeckTest extends BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\StandardDeck::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $suitFactory = new StandardSuitFactory();
        $deck = new StandardDeck($suitFactory);
        $this->assertNotEquals(array(), $this->getPropertyValue($deck, 'items'));

        $this->assertEquals(52, $deck->getSize());

        return $deck;
    }
}
