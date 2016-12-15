<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Cards\Deck;
use PHPPokerAlho\Gameplay\Cards\StandardDeck;
use PHPPokerAlho\Gameplay\Game\Dealer;
use PHPPokerAlho\Gameplay\Game\Table;
use PHPPokerAlho\Gameplay\Game\Player;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class DealerTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $deck = new StandardDeck();
        $dealer = new Dealer($deck);
        $this->assertEquals($deck, $this->getPropertyValue($dealer, 'deck'));

        return $dealer;
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::__construct
     *
     * @since  nextRelease
     */
    public function testConstructWithoutArgs()
    {
        $dealer = new Dealer();
        $this->assertNull($this->getPropertyValue($dealer, 'deck'));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::getDeck
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Dealer $dealer The Dealer
     */
    public function testGetDeck(Dealer $dealer)
    {
        $this->assertEquals(
            $this->getPropertyValue($dealer, 'deck'),
            $dealer->getDeck()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::setDeck
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Dealer $dealer The Dealer
     */
    public function testSetDeck(Dealer $dealer)
    {
        $deck = new Deck();
        $dealer->setDeck($deck);
        $this->assertEquals(
            $deck,
            $this->getPropertyValue($dealer, 'deck')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::getTable
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Dealer $dealer The Dealer
     */
    public function testGetTable(Dealer $dealer)
    {
        $this->assertEquals(
            $this->getPropertyValue($dealer, 'table'),
            $dealer->getTable()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::setTable
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Dealer $dealer The Dealer
     */
    public function testSetTable(Dealer $dealer)
    {
        $table = new Table("Table2");
        $dealer->setTable($table);
        $this->assertEquals(
            $table,
            $this->getPropertyValue($dealer, 'table')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::hasDeck
     *
     * @since  nextRelease
     */
    public function testHasDeck()
    {
        $dealer = new Dealer();
        $this->assertFalse($this->invokeMethod($dealer, "hasDeck"));

        $dealer->setDeck(new Deck());
        $this->assertTrue($this->invokeMethod($dealer, "hasDeck"));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::hasTable
     *
     * @since  nextRelease
     */
    public function testHasTable()
    {
        $dealer = new Dealer();
        $this->assertFalse($this->invokeMethod($dealer, "hasTable"));

        $dealer->setTable(new Table("Round"));
        $this->assertTrue($this->invokeMethod($dealer, "hasTable"));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::deal
     *
     * @since  nextRelease
     */
    public function testDealWithoutDeck()
    {
        $dealer = new Dealer();
        $this->assertFalse($dealer->deal());
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::deal
     *
     * @since  nextRelease
     */
    public function testDealWithoutDeckOrTable()
    {
        $dealer = new Dealer();
        $this->assertFalse($dealer->deal());

        $dealer->setDeck(new Deck());
        $this->assertFalse($dealer->deal());

        $dealer = new Dealer();
        $dealer->setTable(new Table("Table1"));
        $this->assertFalse($dealer->deal());
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::deal
     *
     * @since  nextRelease
     */
    public function testDeal()
    {
        $dealer = new Dealer();
        $dealer->setDeck(new StandardDeck());
        $table = new Table("Table1", 6);
        $dealer->setTable($table);

        $player1 = new Player("Player1");
        $player2 = new Player("Player2");
        $table->addPlayer($player1)->addPlayer($player2);

        $this->assertEmpty($player1->getHand());
        $this->assertEmpty($player2->getHand());
        $this->assertTrue($dealer->deal());

        $this->assertNotEmpty($player1->getHand());
        $this->assertNotEmpty($player2->getHand());
        // $this->assertEquals(
        //     $table,
        //     $this->getPropertyValue($dealer, 'table')
        // );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Dealer::update
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Dealer $dealer The Dealer
     */
    public function testUpdate(Dealer $dealer)
    {
        $table = new Table("Table1", 10);
        $this->assertTrue($dealer->update($table));
    }
}
