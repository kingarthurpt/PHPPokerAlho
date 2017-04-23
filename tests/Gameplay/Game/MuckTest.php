<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Game\Muck;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class MuckTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Muck::getCards
     *
     * @since  nextRelease
     */
    public function testGetCards()
    {
        $muck = new Muck();
        $this->assertNull($muck->getCards());
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Muck::getItems
     *
     * @since  nextRelease
     */
    public function testGetItems()
    {
        $muck = new Muck();
        $this->assertNull($muck->getItems());
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Muck::getCardAt
     *
     * @since  nextRelease
     */
    public function testGetCardAt()
    {
        $muck = new Muck();
        $this->assertNull($muck->getCardAt(0));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Muck::getItemAt
     *
     * @since  nextRelease
     */
    public function testGetItemAt()
    {
        $muck = new Muck();
        $this->assertNull($muck->getItemAt(0));
    }
}
