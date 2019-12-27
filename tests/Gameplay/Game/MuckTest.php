<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\Muck;

class MuckTest extends \Tests\BaseTestCase
{
    public function testGetCards()
    {
        $muck = new Muck();
        $this->assertNull($muck->getCards());
    }

    public function testGetItems()
    {
        $muck = new Muck();
        $this->assertNull($muck->getItems());
    }

    public function testGetCardAt()
    {
        $muck = new Muck();
        $this->assertNull($muck->getCardAt(0));
    }

    public function testGetItemAt()
    {
        $muck = new Muck();
        $this->assertNull($muck->getItemAt(0));
    }
}
