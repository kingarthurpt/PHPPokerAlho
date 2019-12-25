<?php

namespace Tests\Gameplay\Game;

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
class PlayerTest extends \Tests\BaseTestCase
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
}
