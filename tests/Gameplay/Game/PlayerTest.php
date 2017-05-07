<?php

namespace Tests;

use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Game\TableEvent;
use TexasHoldemBundle\Gameplay\Game\PlayerHand;
use TexasHoldemBundle\Gameplay\Game\Stack;
use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class PlayerTest extends BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::__construct
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::__toString
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::getName
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::setName
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::getHand
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::setHand
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::hasButton
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::setButton
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::getSeat
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::setSeat
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::getStack
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::setStack
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::setController
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::update
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::returnHand
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
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::paySmallBlind
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::payBigBlind
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
        $factory = new CardCollectionFactory();
        $player->setHand($factory->makeFromString('As Ac'));

        $this->assertTrue($player->paySmallBlind(10));
        $this->assertEquals(90, $player->getStack()->getSize());

        $this->assertTrue($player->payBigBlind(20));
        $this->assertEquals(70, $player->getStack()->getSize());
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::fold
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

        $factory = new CardCollectionFactory();
        $player->setHand($factory->makeFromString('As Ac'));
        $this->assertTrue($player->fold());
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::check
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::call
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::raise
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::allIn
     * @covers \TexasHoldemBundle\Gameplay\Game\Player::placeBet
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

        $factory = new CardCollectionFactory();
        $player->setHand($factory->makeFromString('As Ac'));
        $this->assertTrue($player->check());
        $this->assertTrue($player->call(20));
        $this->assertTrue($player->raise(40));
        $this->assertTrue($player->allIn());
    }
}
