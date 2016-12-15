<?php

namespace Tests;

use PHPPokerAlho\Game\Player;
use PHPPokerAlho\Game\Table;
use PHPPokerAlho\Cards\Card;
use PHPPokerAlho\Cards\Suit;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class PlayerTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Game\Player::__construct
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
     * @covers \PHPPokerAlho\Game\Player::__toString
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
     * @covers \PHPPokerAlho\Game\Player::getName
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
     * @covers \PHPPokerAlho\Game\Player::setName
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
     * @covers \PHPPokerAlho\Game\Player::getHand
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
     * @covers \PHPPokerAlho\Game\Player::setHand
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
            0 => new Card(1, new Suit("Diamons")),
            1 => new Card(1, new Suit("Hearts"))
        );
        $player->setHand($holeCards);
        $this->assertEquals(
            $holeCards,
            $this->getPropertyValue($player, 'hand')
        );
    }

    /**
     * @covers \PHPPokerAlho\Game\Player::hasButton
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
     * @covers \PHPPokerAlho\Game\Player::setButton
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
     * @covers \PHPPokerAlho\Game\Player::update
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
        $this->assertTrue($player->update($table));
    }
}
