<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Game\TableEvent;
use TexasHoldemBundle\Gameplay\Game\PlayerHand;
use TexasHoldemBundle\Gameplay\Game\PlayerActions;
use TexasHoldemBundle\Gameplay\Game\Stack;
use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;

class PlayerActionsTest extends \Tests\BaseTestCase
{
    private $player;
    private $playerActions;
    private $table;

    protected function setUp(): void
    {
        $this->player = new Player('Player1');
        $this->table = new Table('Table1', 2);
        $this->table->addPlayer($this->player);
        $this->playerActions = new PlayerActions($this->player);
    }

    public function testUpdate()
    {
        $table = new Table("Table1", 10);
        $event = new TableEvent(1, "message");
        $this->assertTrue($this->playerActions->update($table, $event));
    }

    // public function testAddToStack()
    // {
    //     $initialStack = new Stack(10);
    //     $stack = new Stack(100);
    //
    //     $this->player->setStack($initialStack);
    //     $this->playerActions->addToStack($stack);
    //     $this->assertSame(110, $this->player->getStack());
    // }

    public function testReturnHand()
    {
        $holeCards = array(
            0 => new Card(1, new Suit("Diamonds")),
            1 => new Card(1, new Suit("Hearts"))
        );
        $hand = new CardCollection($holeCards, 2);
        $this->player->setHand($hand);

        $this->assertInstanceOf(PlayerHand::class, $this->playerActions->returnHand());
        $this->assertEmpty($this->player->getHand()->getSize());
    }

    // public function testPaySmallBlind(Player $player)
    // {
    //     $player->setStack(new Stack(100));
    //     $table = new Table("Table1", 10);
    //     $table->addPlayer($player);
    //     $factory = new CardCollectionFactory();
    //     $player->setHand($factory->makeFromString('As Ac'));
    //
    //     $this->assertTrue($player->paySmallBlind(10));
    //     $this->assertEquals(90, $player->getStack()->getSize());
    //
    //     $this->assertTrue($player->payBigBlind(20));
    //     $this->assertEquals(70, $player->getStack()->getSize());
    // }

    // public function testFold(Player $player)
    // {
    //     $this->assertFalse($player->fold());
    //
    //     $table = new Table("Table1", 10);
    //     $table->addPlayer($player);
    //     $this->assertFalse($player->fold());
    //
    //     $factory = new CardCollectionFactory();
    //     $player->setHand($factory->makeFromString('As Ac'));
    //     $this->assertTrue($player->fold());
    // }

    // public function testCheckCallRaiseAllin(Player $player)
    // {
    //     $player->setStack(new Stack(500));
    //     $this->assertFalse($player->check());
    //     $this->assertFalse($player->call(20));
    //     $this->assertFalse($player->raise(40));
    //     $this->assertFalse($player->allIn());
    //
    //     $table = new Table("Table1", 10);
    //     $table->addPlayer($player);
    //     $this->assertFalse($player->check());
    //     $this->assertFalse($player->call(20));
    //     $this->assertFalse($player->raise(40));
    //     $this->assertFalse($player->allIn());
    //
    //     $factory = new CardCollectionFactory();
    //     $player->setHand($factory->makeFromString('As Ac'));
    //     $this->assertTrue($player->check());
    //     $this->assertTrue($player->call(20));
    //     $this->assertTrue($player->raise(40));
    //     $this->assertTrue($player->allIn());
    // }
}
