<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;
use TexasHoldemBundle\Gameplay\Game\CommunityCards;
use TexasHoldemBundle\Gameplay\Game\Dealer;
use TexasHoldemBundle\Gameplay\Game\Hand;
use TexasHoldemBundle\Gameplay\Game\Muck;
use TexasHoldemBundle\Gameplay\Game\Player;
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

        return $this->table;
    }

    public function testConstructWithOnlyName()
    {
        $this->table = new Table('Table2');
        $this->assertEquals('Table2', $this->getPropertyValue($this->table, 'name'));
        $this->assertEquals(0, $this->getPropertyValue($this->table, 'seats'));
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
        $this->assertEquals(
            $this->getPropertyValue($this->table, 'name'),
            $this->table->getName()
        );
    }

    public function testSetName()
    {
        $this->table->setName('Table1');
        $this->assertEquals(
            'Table1',
            $this->getPropertyValue($this->table, 'name')
        );
    }

    public function testGetSeatsCount()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->table, 'seats'),
            $this->table->getSeatsCount()
        );
    }

    public function testSetSeatsCount()
    {
        $this->table->setSeatsCount(10);
        $this->assertEquals(
            10,
            $this->getPropertyValue($this->table, 'seats')
        );
    }

    public function testGetDealer()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->table, 'dealer'),
            $this->table->getDealer()
        );
    }

    public function testSetDealer()
    {
        $suitFactory = new StandardSuitFactory();
        $deck = new StandardDeck($suitFactory);
        $this->table = new Table('Table1', 10);
        $dealer = new Dealer($deck, $this->table);
        $this->table->setDealer($dealer);
        $this->assertEquals(
            $dealer,
            $this->getPropertyValue($this->table, 'dealer')
        );
    }

    public function testAddPlayerWhenTableIsFull()
    {
        $player = new Player('Player1');
        $this->table->setSeatsCount(0);
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
        $this->assertEquals(
            $this->getPropertyValue($this->table, 'communityCards'),
            $this->table->getCommunityCards()
        );
    }

    public function testSetCommunityCards()
    {
        $communityCards = new CommunityCards();
        $this->table->setCommunityCards($communityCards);
        $this->assertEquals(
            $communityCards,
            $this->getPropertyValue($this->table, 'communityCards')
        );
    }

    public function testGetMuck()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->table, 'muck'),
            $this->table->getMuck()
        );
    }

    public function testSetMuck()
    {
        $muck = new Muck();
        $this->table->setMuck($muck);
        $this->assertEquals(
            $muck,
            $this->getPropertyValue($this->table, 'muck')
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

        $this->table->addPlayer($player1);
        $player1->getPlayerActions()->paySmallBlind(10.0);
        $bets = $this->table->getPlayersBets();
        $this->assertSame($bets[0], $this->table->getPlayerBets($player1));

        $this->assertNull($this->table->getPlayerBets($player2));
    }
}
