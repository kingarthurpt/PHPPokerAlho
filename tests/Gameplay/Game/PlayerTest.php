<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Game\Player;
use PHPPokerAlho\Gameplay\Game\Table;
use PHPPokerAlho\Gameplay\Game\TableEvent;
use PHPPokerAlho\Gameplay\Game\PlayerHand;
use PHPPokerAlho\Gameplay\Game\Stack;
use PHPPokerAlho\Gameplay\Cards\Card;
use PHPPokerAlho\Gameplay\Cards\Suit;
use PHPPokerAlho\Gameplay\Cards\CardCollection;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class PlayerTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $player = new Player('Player1');
        $this->assertEquals('Player1', $this->getPropertyValue($player, 'name'));

        return $player;
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::__toString
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testToString(Player $player)
    {
        $this->assertEquals(
            $this->getPropertyValue($player, 'name'),
            $player
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::getName
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testGetName(Player $player)
    {
        $this->assertEquals(
            $this->getPropertyValue($player, 'name'),
            $player->getName()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::setName
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testSetName(Player $player)
    {
        $player->setName("Player1");
        $this->assertEquals(
            "Player1",
            $this->getPropertyValue($player, 'name')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::getHand
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testGetHand(Player $player)
    {
        $this->assertEquals(
            $this->getPropertyValue($player, 'hand'),
            $player->getHand()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::setHand
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testSetHand(Player $player)
    {
        $holeCards = array(
            0 => new Card(1, new Suit("Diamonds")),
            1 => new Card(1, new Suit("Hearts"))
        );
        $hand = new CardCollection($holeCards, 2);
        $player->setHand($hand);

        $this->assertInstanceOf(
            PlayerHand::class,
            $this->getPropertyValue($player, 'hand')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::hasButton
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testHasButton(Player $player)
    {
        $this->assertEquals(
            $this->getPropertyValue($player, 'button'),
            $player->hasButton()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::setButton
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testSetButton(Player $player)
    {
        $player->setButton(true);
        $this->assertTrue($this->getPropertyValue($player, 'button'));
        $player->setButton(false);
        $this->assertFalse($this->getPropertyValue($player, 'button'));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::getSeat
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testGetSeat(Player $player)
    {
        $this->assertEquals(
            $this->getPropertyValue($player, 'seat'),
            $player->getSeat()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::setSeat
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testSetSeat(Player $player)
    {
        $player->setSeat(2);
        $this->assertEquals(2, $this->getPropertyValue($player, 'seat'));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::getStack
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testGetStack(Player $player)
    {
        $this->assertEquals(
            $this->getPropertyValue($player, 'stack'),
            $player->getStack()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::setStack
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testSetStack(Player $player)
    {
        $stack = new Stack(1000);
        $this->assertNull($player->setStack($stack));

        $table = new Table("Table1", 2);
        $player->update($table, new TableEvent(1, "test"));
        $this->assertNotNull($player->setStack($stack));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::setController
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testSetController(Player $player)
    {
        $player->setController("some controller");
        $this->assertEquals(
            "some controller",
            $this->getPropertyValue($player, 'controller')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::update
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testUpdate(Player $player)
    {
        $table = new Table("Table1", 10);
        $event = new TableEvent(1, "message");
        $this->assertTrue($player->update($table, $event));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::returnHand
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testReturnHand(Player $player)
    {
        $holeCards = array(
            0 => new Card(1, new Suit("Diamonds")),
            1 => new Card(1, new Suit("Hearts"))
        );
        $hand = new CardCollection($holeCards, 2);
        $player->setHand($hand);

        $this->assertInstanceOf(PlayerHand::class, $player->returnHand());
        $this->assertEmpty($player->getHand());
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::paySmallBlind
     * @covers \PHPPokerAlho\Gameplay\Game\Player::payBigBlind
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testPaySmallBlind(Player $player)
    {
        $player->setStack(new Stack(100));
        $table = new Table("Table1", 10);
        $table->addPlayer($player);
        $player->setHand(CardCollection::fromString('As Ac'));

        $this->assertTrue($player->paySmallBlind(10));
        $this->assertEquals(90, $player->getStack()->getSize());

        $this->assertTrue($player->payBigBlind(20));
        $this->assertEquals(70, $player->getStack()->getSize());
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::fold
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testFold(Player $player)
    {
        $this->assertFalse($player->fold());

        $table = new Table("Table1", 10);
        $table->addPlayer($player);
        $this->assertFalse($player->fold());

        $player->setHand(CardCollection::fromString('As Ac'));
        $this->assertTrue($player->fold());
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\Player::check
     * @covers \PHPPokerAlho\Gameplay\Game\Player::call
     * @covers \PHPPokerAlho\Gameplay\Game\Player::raise
     * @covers \PHPPokerAlho\Gameplay\Game\Player::allIn
     * @covers \PHPPokerAlho\Gameplay\Game\Player::placeBet
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Player $player The Player
     */
    public function testCheckCallRaiseAllin(Player $player)
    {
        $player->setStack(new Stack(500));
        $this->assertFalse($player->check());
        $this->assertFalse($player->call(20));
        $this->assertFalse($player->raise(40));
        $this->assertFalse($player->allIn());

        $table = new Table("Table1", 10);
        $table->addPlayer($player);
        $this->assertFalse($player->check());
        $this->assertFalse($player->call(20));
        $this->assertFalse($player->raise(40));
        $this->assertFalse($player->allIn());

        $player->setHand(CardCollection::fromString('As Ac'));
        $this->assertTrue($player->check());
        $this->assertTrue($player->call(20));
        $this->assertTrue($player->raise(40));
        $this->assertTrue($player->allIn());
    }
}
