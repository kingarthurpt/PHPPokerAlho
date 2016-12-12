<?php

namespace Tests;

use PHPPokerAlho\Game\Table;
use PHPPokerAlho\Game\Dealer;
use PHPPokerAlho\Game\Player;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class TableTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Game\Table::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $table = new Table('Table1', 6);
        $this->assertEquals('Table1', $this->getPropertyValue($table, 'name'));
        $this->assertEquals(6, $this->getPropertyValue($table, 'seats'));

        return $table;
    }

    /**
     * @covers \PHPPokerAlho\Game\Table::__construct
     *
     * @since  nextRelease
     */
    public function testConstructWithOnlyName()
    {
        $table = new Table('Table2');
        $this->assertEquals('Table2', $this->getPropertyValue($table, 'name'));
        $this->assertEquals(null, $this->getPropertyValue($table, 'seats'));
    }

    /**
     * @covers \PHPPokerAlho\Game\Table::__toString
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
     * @covers \PHPPokerAlho\Game\Table::getName
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
     * @covers \PHPPokerAlho\Game\Table::setName
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
     * @covers \PHPPokerAlho\Game\Table::getSeatsCount
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
     * @covers \PHPPokerAlho\Game\Table::setSeatsCount
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
     * @covers \PHPPokerAlho\Game\Table::getDealer
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
     * @covers \PHPPokerAlho\Game\Table::setDealer
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
     * @covers \PHPPokerAlho\Game\Table::addPlayer
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
     * @covers \PHPPokerAlho\Game\Table::addPlayer
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testAddPlayer(Table $table)
    {
        $player = new Player("Player1");
        $table->setSeatsCount(10);
        $this->assertInstanceOf(Table::class, $table->addPlayer($player));
    }

    /**
     * @covers \PHPPokerAlho\Game\Table::addPlayer
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Table $table The Table
     */
    public function testAddPlayerAlreadySeated(Table $table)
    {
        $player = new Player("Player1");
        $this->assertNull($table->addPlayer($player));
    }

    /**
     * @covers \PHPPokerAlho\Game\Table::getPlayerCount
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
}
