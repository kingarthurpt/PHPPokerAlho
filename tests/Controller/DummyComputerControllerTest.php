<?php

namespace Tests\Controller;

use TexasHoldemBundle\Controller\DummyComputerController;
use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Game\Event\PaymentRequiredTableEvent;
use TexasHoldemBundle\Gameplay\Game\Event\TableEvent;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Stack;
use TexasHoldemBundle\Gameplay\Game\TableFactory;

class DummyComputerControllerTest extends \Tests\BaseTestCase
{
    private $controller;

    protected function setUp(): void
    {
        $this->player = new Player('Player1');
        $this->player->setStack(new Stack(1000));
        $tableFactory = new TableFactory();
        $table = $tableFactory->makeTableWithDealer('test', 2);

        $table->addPlayer($this->player);
        // $table->getDealer()->startNewHand();

        $this->controller = new DummyComputerController($this->player);
    }

    public function testHandleEvent()
    {
        $this->assertEquals(1000, $this->player->getStack()->getSize());

        $this->assertNull(
            $this->controller->handleEvent(new TableEvent(TableEvent::PLAYER_JOINS))
        );
    }

    public function testHandlePaySmallBlind()
    {
        $event = new PaymentRequiredTableEvent(
            TableEvent::ACTION_PLAYER_PAY_SMALL_BLIND,
            50
        );

        $this->assertNull(
            $this->controller->handleEvent($event)
        );
        $this->assertEquals(950, $this->player->getStack()->getSize());
    }

    public function testHandlePayBigBlind()
    {
        $event = new PaymentRequiredTableEvent(
            TableEvent::ACTION_PLAYER_PAY_BIG_BLIND,
            100
        );

        $this->assertNull($this->controller->handleEvent($event));
        $this->assertEquals(900, $this->player->getStack()->getSize());
    }

    public function testHandleReceivedCards()
    {
        $factory = new CardCollectionFactory();
        $this->player->setHand($factory->makeFromString('2s 2c'));

        $event = new TableEvent(TableEvent::PLAYER_RECEIVED_CARDS);
        $this->assertNull($this->controller->handleEvent($event));
    }
}
