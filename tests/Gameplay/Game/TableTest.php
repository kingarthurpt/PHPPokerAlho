<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;
use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Game\Dealer;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\CommunityCards;
use TexasHoldemBundle\Gameplay\Game\Muck;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class TableTest extends \Tests\BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $table = new Table('Table1', 6);
        $this->assertEquals('Table1', $this->getPropertyValue($table, 'name'));
        $this->assertEquals(6, $this->getPropertyValue($table, 'seats'));
        $this->assertEquals(array(), $this->getPropertyValue($table, 'players'));
        $this->assertInstanceOf(
            CommunityCards::class,
            $this->getPropertyValue($table, 'communityCards')
        );
        $this->assertInstanceOf(
            Muck::class,
            $this->getPropertyValue($table, 'muck')
        );

        return $table;
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::__construct
     *
     * @since  nextRelease
     */
    public function testConstructWithOnlyName()
    {
        $table = new Table('Table2');
        $this->assertEquals('Table2', $this->getPropertyValue($table, 'name'));
        $this->assertEquals(0, $this->getPropertyValue($table, 'seats'));
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::__toString
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testToString(Table $table)
    {
        $this->assertEquals(
            $this->getPropertyValue($table, 'name'),
            $table
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::getName
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testGetName(Table $table)
    {
        $this->assertEquals(
            $this->getPropertyValue($table, 'name'),
            $table->getName()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::setName
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testSetName(Table $table)
    {
        $table->setName("Table1");
        $this->assertEquals(
            "Table1",
            $this->getPropertyValue($table, 'name')
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::getSeatsCount
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testGetSeatsCount(Table $table)
    {
        $this->assertEquals(
            $this->getPropertyValue($table, 'seats'),
            $table->getSeatsCount()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::setSeatsCount
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testSetSeatsCount(Table $table)
    {
        $table->setSeatsCount(10);
        $this->assertEquals(
            10,
            $this->getPropertyValue($table, 'seats')
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::getDealer
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testGetDealer(Table $table)
    {
        $this->assertEquals(
            $this->getPropertyValue($table, 'dealer'),
            $table->getDealer()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::setDealer
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testSetDealer(Table $table)
    {
        $suitFactory = new StandardSuitFactory();
        $deck = new StandardDeck($suitFactory);
        $table = new Table("Table1", 10);
        $dealer = new Dealer($deck, $table);
        $table->setDealer($dealer);
        $this->assertEquals(
            $dealer,
            $this->getPropertyValue($table, 'dealer')
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::addPlayer
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testAddPlayerWhenTableIsFull(Table $table)
    {
        $player = new Player("Player1");
        $table->setSeatsCount(0);
        $table->addPlayer($player);
        $this->assertNull($table->addPlayer($player));
        $table->setSeatsCount(10);
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::addPlayer
     *
     * @since  nextRelease
     */
    public function testAddPlayer()
    {
        $table = new Table('Table1', 6);
        $player = new Player("Player1");
        $table->setSeatsCount(10);

        $this->assertInstanceOf(Table::class, $table->addPlayer($player));
        $this->assertEquals(1, $table->getPlayerCount());
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::removePlayer
     *
     * @since  nextRelease
     */
    public function testRemovePlayer()
    {
        $table = new Table('Table1', 6);
        $player1 = new Player("Player1");
        $player2 = new Player("Player2");
        $table->setSeatsCount(10);

        $this->assertFalse($table->removePlayer($player1));

        $table->addPlayer($player1);
        $this->assertFalse($table->removePlayer($player2));

        $this->assertEquals(1, $table->getPlayerCount());
        $this->assertTrue($table->removePlayer($player1));
        $this->assertEquals(0, $table->getPlayerCount());

    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::addPlayer
     *
     * @since  nextRelease
     */
    public function testAddPlayerAlreadySeated()
    {
        $table = new Table('Table1', 6);
        $player = new Player("Player1");
        $this->assertInstanceOf(Table::class, $table->addPlayer($player));
        $this->assertNull($table->addPlayer($player));
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::getPlayerCount
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testGetPlayerCount(Table $table)
    {
        $this->assertEquals(
            count($this->getPropertyValue($table, 'players')),
            $table->getPlayerCount()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::getPlayers
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testGetPlayers(Table $table)
    {
        $this->assertEquals(
            $this->getPropertyValue($table, 'players'),
            $table->getPlayers()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::getCommunityCards
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testGetCommunityCards(Table $table)
    {
        $this->assertEquals(
            $this->getPropertyValue($table, 'communityCards'),
            $table->getCommunityCards()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::setCommunityCards
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testSetCommunityCards(Table $table)
    {
        $communityCards = new CommunityCards();
        $table->setCommunityCards($communityCards);
        $this->assertEquals(
            $communityCards,
            $this->getPropertyValue($table, 'communityCards')
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::getMuck
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testGetMuck(Table $table)
    {
        $this->assertEquals(
            $this->getPropertyValue($table, 'muck'),
            $table->getMuck()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Table::setMuck
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testSetMuck(Table $table)
    {
        $muck = new Muck();
        $table->setMuck($muck);
        $this->assertEquals(
            $muck,
            $this->getPropertyValue($table, 'muck')
        );
    }

    public function testGetSeatOfPlayerWithButton()
    {
        $player1 = new Player('player1');
        $table = new Table('table1', 2);
        $table->addPlayer($player1);

        $this->assertSame(
            0,
            $table->getSeatOfPlayerWithButton()
        );
    }
}
