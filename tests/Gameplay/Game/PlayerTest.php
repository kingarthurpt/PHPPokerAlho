<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\PlayerHand;
use TexasHoldemBundle\Gameplay\Game\Stack;

class PlayerTest extends \Tests\BaseTestCase
{
    private $player;

    protected function setUp(): void
    {
        $this->player = new Player('Player1');
    }

    public function testConstruct()
    {
        $this->assertEquals('Player1', $this->getPropertyValue($this->player, 'name'));
    }

    public function testToString()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->player, 'name'),
            $this->player
        );
    }

    public function testGetName()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->player, 'name'),
            $this->player->getName()
        );
    }

    public function testSetName()
    {
        $this->player->setName('Player1');
        $this->assertEquals(
            'Player1',
            $this->getPropertyValue($this->player, 'name')
        );
    }

    public function testGetHand()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->player, 'hand'),
            $this->player->getHand()
        );
    }

    public function testSetHand()
    {
        $holeCards = [
            0 => new Card(1, new Suit('Diamonds')),
            1 => new Card(1, new Suit('Hearts')),
        ];
        $hand = new CardCollection($holeCards, 2);
        $this->player->setHand($hand);

        $this->assertInstanceOf(
            PlayerHand::class,
            $this->getPropertyValue($this->player, 'hand')
        );
    }

    public function testHasButton()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->player, 'button'),
            $this->player->hasButton()
        );
    }

    public function testSetButton()
    {
        $this->player->setButton(true);
        $this->assertTrue($this->getPropertyValue($this->player, 'button'));
        $this->player->setButton(false);
        $this->assertFalse($this->getPropertyValue($this->player, 'button'));
    }

    public function testGetSeat()
    {
        $seat = 2;
        $this->assertInstanceOf(Player::class, $this->player->setSeat($seat));

        $this->assertEquals(
            $seat,
            $this->player->getSeat()
        );
    }

    public function testGetStack()
    {
        $stack = new Stack(100);
        $this->assertInstanceOf(Player::class, $this->player->setStack($stack));

        $this->assertEquals(
            $stack,
            $this->player->getStack()
        );
    }

    public function testDoAction()
    {
        $this->assertNull($this->player->doAction('invalidAction'));

        $action = 'showHand';
        $this->assertSame(
            $this->player->getPlayerActions()->$action(),
            $this->player->doAction($action)
        );
    }
}
