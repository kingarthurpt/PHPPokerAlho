<?php

namespace Tests;

use TexasHoldemBundle\Gameplay\Cards\StandardDeck;

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
        $deck = new StandardDeck();
        $this->assertNotEquals(array(), $this->getPropertyValue($deck, 'items'));

        $this->assertEquals(52, $deck->getSize());

        return $deck;
    }
}
