<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Cards\Card;
use PHPPokerAlho\Gameplay\Cards\Suit;
use PHPPokerAlho\Gameplay\Game\Table;
use PHPPokerAlho\Gameplay\Game\Dealer;
use PHPPokerAlho\Gameplay\Game\Player;
use PHPPokerAlho\Gameplay\Game\CommunityCards;
use PHPPokerAlho\Gameplay\Game\Muck;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class TableTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Table::__construct
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
            \PHPPokerAlho\Gameplay\Game\CommunityCards::class,
            $this->getPropertyValue($table, 'communityCards')
        );
        $this->assertInstanceOf(
            \PHPPokerAlho\Gameplay\Game\Muck::class,
            $this->getPropertyValue($table, 'muck')
        );

        return $table;
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Table::__construct
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::__toString
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::getName
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::setName
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::getSeatsCount
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::setSeatsCount
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::getDealer
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::setDealer
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testSetDealer(Table $table)
    {
        $dealer = new Dealer();
        $table->setDealer($dealer);
        $this->assertEquals(
            $dealer,
            $this->getPropertyValue($table, 'dealer')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Table::addPlayer
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::addPlayer
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::removePlayer
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::addPlayer
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::getPlayerCount
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::getPlayers
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::getCommunityCards
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::setCommunityCards
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::getMuck
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
     * @covers \PHPPokerAlho\Gameplay\Game\Table::setMuck
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
}
