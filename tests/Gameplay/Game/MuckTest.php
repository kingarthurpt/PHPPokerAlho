<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\Muck;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class MuckTest extends \Tests\BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Muck::getCards
     *
     * @since  nextRelease
     */
    public function testGetCards()
    {
        $muck = new Muck();
        $this->assertNull($muck->getCards());
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Muck::getItems
     *
     * @since  nextRelease
     */
    public function testGetItems()
    {
        $muck = new Muck();
        $this->assertNull($muck->getItems());
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Muck::getCardAt
     *
     * @since  nextRelease
     */
    public function testGetCardAt()
    {
        $muck = new Muck();
        $this->assertNull($muck->getCardAt(0));
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Muck::getItemAt
     *
     * @since  nextRelease
     */
    public function testGetItemAt()
    {
        $muck = new Muck();
        $this->assertNull($muck->getItemAt(0));
    }
}
