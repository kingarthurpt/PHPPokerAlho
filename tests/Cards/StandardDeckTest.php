<?php

namespace Tests;

use PHPPokerAlho\Cards\StandardDeck;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardDeckTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Cards\StandardDeck::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $deck = new StandardDeck();
        $this->assertNotEquals(array(), $this->getPropertyValue($deck, 'cards'));

        $this->assertEquals(52, $deck->getSize());

        return $deck;
    }
}
