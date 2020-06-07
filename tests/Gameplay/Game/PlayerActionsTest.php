<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Controller\DummyComputerController;
use TexasHoldemBundle\Exception\PlayerHandIsEmptyException;
use TexasHoldemBundle\Exception\PlayerNotSeatedException;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Cards\StandardCard;
use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Gameplay\Game\Event\TableEvent;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\PlayerActions;
use TexasHoldemBundle\Gameplay\Game\PlayerHand;
use TexasHoldemBundle\Gameplay\Game\Stack;
use TexasHoldemBundle\Gameplay\Game\Table;

class PlayerActionsTest extends \Tests\BaseTestCase
{
    private $player;
    private $playerActions;
    private $table;

    protected function setUp(): void
    {
        $this->player = new Player('Player1');
        $this->playerActions = $this->player->getPlayerActions();
        $computerController = new DummyComputerController($this->player);
        $this->playerActions->setController($computerController);

        $this->table = new Table('Table1', 2);
        $this->table->addPlayer($this->player);
    }

    public function testUpdate()
    {
        $table = new Table('Table1', 10);
        $event = new TableEvent(TableEvent::PLAYER_JOINS, 'message');

        $this->assertTrue($this->playerActions->update($table, $event));
    }

    public function testAddToStackPlayerNotSeatedException()
    {
        $playerActions = new PlayerActions($this->player);
        $this->expectException(PlayerNotSeatedException::class);
        $this->expectExceptionMessage('The player Player1 is not seated at a table yet');

        $stack = new Stack(100);
        $playerActions->addToStack($stack);
    }

    public function testAddToStack()
    {
        $table = new Table('Table1', 10);
        $event = new TableEvent(TableEvent::PLAYER_JOINS, 'message');
        $this->playerActions->update($table, $event);

        $initialStack = new Stack(10);
        $stack = new Stack(100);

        $this->player->setStack($initialStack);
        $this->playerActions->addToStack($stack);
        $this->assertEquals(110, $this->player->getStack()->getSize());
    }

    public function testReturnHand()
    {
        $holeCards = [
            0 => new StandardCard(14, new Suit('Diamonds')),
            1 => new StandardCard(14, new Suit('Hearts')),
        ];

        $hand = new CardCollection($holeCards, 2);
        $this->player->setHand($hand);

        $this->assertInstanceOf(PlayerHand::class, $this->playerActions->returnHand());
        $this->assertEmpty($this->player->getHand()->getSize());
    }

    public function testPaySmallBlindPlayerNotSeatedException()
    {
        $playerActions = new PlayerActions($this->player);
        $this->expectException(PlayerNotSeatedException::class);
        $this->expectExceptionMessage('The player Player1 is not seated at a table yet');

        $playerActions->paySmallBlind(10);
    }

    public function testPaySmallBlind()
    {
        $this->player->setStack(new Stack(100));
        $factory = new CardCollectionFactory();
        $this->player->setHand($factory->makeFromString('As Ac'));

        $this->assertTrue($this->playerActions->paySmallBlind(10));
        $this->assertEquals(90, $this->player->getStack()->getSize());

        $this->assertTrue($this->playerActions->payBigBlind(20));
        $this->assertEquals(70, $this->player->getStack()->getSize());
    }

    public function testFoldPlayerNotSeatedException()
    {
        $playerActions = new PlayerActions($this->player);
        $this->expectException(PlayerNotSeatedException::class);
        $this->expectExceptionMessage('The player Player1 is not seated at a table yet');

        $playerActions->fold();
    }

    public function testFoldPlayerHandIsEmptyException()
    {
        $this->expectException(PlayerHandIsEmptyException::class);
        $this->expectExceptionMessage('The hand of player Player1 is empty');

        $this->playerActions->fold();
    }

    public function testFold()
    {
        $factory = new CardCollectionFactory();
        $hand = $factory->makeFromString('As Ac');
        $this->player->setHand($hand);
        $playerHand = $this->player->getHand();

        $this->assertEquals($playerHand->__toString(), $hand->__toString());
        $this->assertEquals($playerHand, $this->playerActions->fold());
    }

    public function testCheckPlayerNotSeatedException()
    {
        $playerActions = new PlayerActions($this->player);
        $this->expectException(PlayerNotSeatedException::class);
        $this->expectExceptionMessage('The player Player1 is not seated at a table yet');

        $playerActions->check();
    }

    public function testCheckPlayerHandIsEmptyException()
    {
        $this->expectException(PlayerHandIsEmptyException::class);
        $this->expectExceptionMessage('The hand of player Player1 is empty');

        $this->playerActions->check();
    }

    public function testCheck()
    {
        $factory = new CardCollectionFactory();
        $hand = $factory->makeFromString('As Ac');
        $this->player->setHand($hand);

        $this->assertTrue($this->playerActions->check());
    }

    public function testCallRaiseAllin()
    {
        $this->player->setStack(new Stack(500));

        $this->assertFalse($this->playerActions->call(20));
        $this->assertFalse($this->playerActions->raise(40));
        $this->assertFalse($this->playerActions->allIn());

        $factory = new CardCollectionFactory();
        $hand = $factory->makeFromString('As Ac');
        $this->player->setHand($hand);

        $this->assertTrue($this->playerActions->call(20));
        $this->assertTrue($this->playerActions->raise(40));
        $this->assertTrue($this->playerActions->allIn());
    }

    public function testShowHandPlayerNotSeatedException()
    {
        $playerActions = new PlayerActions($this->player);
        $this->expectException(PlayerNotSeatedException::class);
        $this->expectExceptionMessage('The player Player1 is not seated at a table yet');

        $playerActions->showHand();
    }

    public function testShowHand()
    {
        $factory = new CardCollectionFactory();
        $hand = $factory->makeFromString('As Ac');
        $this->player->setHand($hand);

        $playerHand = $this->playerActions->showHand();
        $this->assertEquals($playerHand->__toString(), $hand->__toString());
        $this->assertEquals($playerHand, $this->playerActions->showHand());
    }

    public function testMuckHandPlayerNotSeatedException()
    {
        $playerActions = new PlayerActions($this->player);
        $this->expectException(PlayerNotSeatedException::class);
        $this->expectExceptionMessage('The player Player1 is not seated at a table yet');

        $playerActions->muckHand();
    }

    public function testMuckHand()
    {
        $factory = new CardCollectionFactory();
        $hand = $factory->makeFromString('As Ac');
        $this->player->setHand($hand);

        $this->assertNull($this->playerActions->muckHand());
        // $this->assertEquals($playerHand->__toString(), $hand->__toString());
        // $this->assertEquals($playerHand, $this->playerActions->showHand());
    }
}
