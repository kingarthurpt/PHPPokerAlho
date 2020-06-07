<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Exception\PlayerAlreadySeatedException;
use TexasHoldemBundle\Exception\TableFullException;
use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;
use TexasHoldemBundle\Gameplay\Game\CommunityCards;
use TexasHoldemBundle\Gameplay\Game\Dealer;
use TexasHoldemBundle\Gameplay\Game\Hand;
use TexasHoldemBundle\Gameplay\Game\Muck;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Stack;
use TexasHoldemBundle\Gameplay\Game\Table;

class TableTest extends \Tests\BaseTestCase
{
    private $table;

    protected function setUp(): void
    {
        $this->table = new Table('Table1', 6);
    }

    public function testConstruct()
    {
        $this->assertEquals('Table1', $this->getPropertyValue($this->table, 'name'));
        $this->assertEquals(6, $this->getPropertyValue($this->table, 'seats'));
        $this->assertEquals([], $this->getPropertyValue($this->table, 'players'));
        $this->assertInstanceOf(
            CommunityCards::class,
            $this->getPropertyValue($this->table, 'communityCards')
        );
        $this->assertInstanceOf(
            Muck::class,
            $this->getPropertyValue($this->table, 'muck')
        );

        $table = new Table('Table2');
        $this->assertEquals('Table2', $this->getPropertyValue($table, 'name'));
        $this->assertEquals(0, $this->getPropertyValue($table, 'seats'));
    }

    public function testToString()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->table, 'name'),
            $this->table
        );
    }

    public function testGetName()
    {
        $name = 'Table10';
        $this->table->setName($name);
        $this->assertEquals(
            $name,
            $this->table->getName()
        );
    }

    public function testGetSeatsCount()
    {
        $count = 10;
        $this->table->setSeatsCount($count);
        $this->assertEquals(
            $count,
            $this->table->getSeatsCount()
        );
    }

    public function testGetDealer()
    {
        $suitFactory = new StandardSuitFactory();
        $deck = new StandardDeck($suitFactory);
        $this->table = new Table('Table1', 10);
        $dealer = new Dealer($deck, $this->table);

        $this->table->setDealer($dealer);
        $this->assertEquals(
            $dealer,
            $this->table->getDealer()
        );
    }

    public function testAddPlayerWhenTableIsFull()
    {
        $player = new Player('Player1');
        $this->table->setSeatsCount(0);

        $this->expectException(TableFullException::class);
        $this->expectExceptionMessage('The table Table1 is full');

        $this->table->addPlayer($player);
        $this->assertNull($this->table->addPlayer($player));
        $this->table->setSeatsCount(10);
    }

    public function testAddPlayer()
    {
        $this->table = new Table('Table1', 6);
        $player = new Player('Player1');
        $this->table->setSeatsCount(10);

        $this->assertInstanceOf(Table::class, $this->table->addPlayer($player));
        $this->assertEquals(1, count($this->table->getPlayers()));
    }

    public function testRemovePlayer()
    {
        $this->table = new Table('Table1', 6);
        $player1 = new Player('Player1');
        $player2 = new Player('Player2');
        $this->table->setSeatsCount(10);

        $this->assertFalse($this->table->removePlayer($player1));

        $this->table->addPlayer($player1);
        $this->assertFalse($this->table->removePlayer($player2));

        $this->assertEquals(1, count($this->table->getPlayers()));
        $this->assertTrue($this->table->removePlayer($player1));
        $this->assertEquals(0, count($this->table->getPlayers()));
    }

    public function testAddPlayerAlreadySeated()
    {
        $this->table = new Table('Table1', 6);
        $player = new Player('Player1');

        $this->expectException(PlayerAlreadySeatedException::class);
        $this->expectExceptionMessage('The player Player1 is already seated at table Table1');

        $this->assertInstanceOf(Table::class, $this->table->addPlayer($player));
        $this->assertNull($this->table->addPlayer($player));
    }

    public function testGetPlayers()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->table, 'players'),
            $this->table->getPlayers()
        );
    }

    public function testGetCommunityCards()
    {
        $communityCards = new CommunityCards();
        $this->table->setCommunityCards($communityCards);
        $this->assertEquals(
            $communityCards,
            $this->table->getCommunityCards()
        );
    }

    public function testGetMuck()
    {
        $muck = new Muck();
        $this->table->setMuck($muck);
        $this->assertEquals(
            $muck,
            $this->table->getMuck()
        );
    }

    public function testGetSeatOfPlayerWithButton()
    {
        $player1 = new Player('player1');
        $this->table = new Table('table1', 2);
        $this->table->addPlayer($player1);

        $this->assertSame(
            0,
            $this->table->getSeatOfPlayerWithButton()
        );
    }

    public function testGetActiveHand()
    {
        $hand = new Hand();
        $this->assertInstanceOf(Table::class, $this->table->setActiveHand($hand));
        $this->assertSame($hand, $this->table->getActiveHand());
    }

    public function testGetPlayersBets()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->table, 'playersBets'),
            $this->table->getPlayersBets()
        );
    }

    public function testGetPlayerBets()
    {
        $player1 = new Player('Player1');
        $player2 = new Player('Player2');
        $this->assertNull($this->table->getPlayerBets($player1));

        $player1->setStack(new Stack(300));
        $this->table->addPlayer($player1);
        $player1->getPlayerActions()->paySmallBlind(10.0);
        $bets = $this->table->getPlayersBets();
        $this->assertSame($bets[0], $this->table->getPlayerBets($player1));

        $this->assertNull($this->table->getPlayerBets($player2));
    }
}
