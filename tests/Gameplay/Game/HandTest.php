<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\Hand;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Table;

class HandTest extends \Tests\BaseTestCase
{
    private $hand;

    protected function setUp(): void
    {
        $this->hand = new Hand();
    }

    public function testConstruct()
    {
        $this->assertNotNull($this->hand->getId());
        $this->assertNotNull($this->hand->getDatetime());
    }

    public function testGetTable()
    {
        $table = new Table('Table1', 2);
        $this->hand->setTable($table);
        $this->assertSame($table, $this->hand->getTable());
    }

    public function testGetPlayers()
    {
        $player = new Player('Player1');
        $this->hand->setPlayers([$player]);
        $this->assertContains($player, $this->hand->getPlayers());
    }

    public function testGetSmallBigBlind()
    {
        $blind = 20;
        $this->hand->setSmallBlind($blind);
        $this->assertEquals($blind, $this->hand->getSmallBlind());

        $blind = 30;
        $this->hand->setBigBlind($blind);
        $this->assertEquals($blind, $this->hand->getBigBlind());
    }
}
