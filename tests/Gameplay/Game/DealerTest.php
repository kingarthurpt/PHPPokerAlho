<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Cards\Deck;
use TexasHoldemBundle\Gameplay\Cards\StandardDeck;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;
use TexasHoldemBundle\Gameplay\Game\Dealer;
use TexasHoldemBundle\Gameplay\Game\Event\TableEvent;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Game\TableFactory;

class DealerTest extends \Tests\BaseTestCase
{
    private $dealer;
    private $deck;

    protected function setUp(): void
    {
        $suitFactory = new StandardSuitFactory();
        $this->deck = new StandardDeck($suitFactory);
        $table = new Table('Table1', 10);
        $this->dealer = new Dealer($this->deck, $table);
    }

    public function testGetDeck()
    {
        $this->assertSame(
            $this->getPropertyValue($this->dealer, 'deck'),
            $this->dealer->getDeck()
        );
    }

    public function testSetDeck()
    {
        $deck = new Deck();
        $this->dealer->setDeck($deck);
        $this->assertSame(
            $deck,
            $this->getPropertyValue($this->dealer, 'deck')
        );
    }

    public function testGetTable()
    {
        $this->assertSame(
            $this->getPropertyValue($this->dealer, 'table'),
            $this->dealer->getTable()
        );
    }

    public function testSetTable()
    {
        $table = new Table('Table2');
        $this->dealer->setTable($table);
        $this->assertSame(
            $table,
            $this->getPropertyValue($this->dealer, 'table')
        );
    }

    public function testDeal()
    {
        $dealer = $this->getDealer();
        $table = $dealer->getTable();

        $player1 = new Player('Player1');
        $player2 = new Player('Player2');
        $table->addPlayer($player1)->addPlayer($player2);

        $this->assertEmpty($player1->getHand());
        $this->assertEmpty($player2->getHand());

        $suitFactory = new StandardSuitFactory();
        $this->deck = new StandardDeck($suitFactory);

        $cards = new CardCollection();
        $cards->addCard($this->deck->drawRandomCard());
        $cards->addCard($this->deck->drawRandomCard());
        $player1->setHand($cards);

        $this->assertNotEmpty($player1->getHand());
        $this->assertEmpty($player2->getHand());

        $this->assertTrue($dealer->deal());
        $this->assertNotEmpty($player1->getHand());
        $this->assertNotEmpty($player2->getHand());
    }

    public function testUpdate()
    {
        $table = new Table('Table1', 10);
        $event = new TableEvent(1, 'some message');
        $this->assertTrue($this->dealer->update($table, $event));
    }

    public function testDealFlop()
    {
        $this->doTestDealCommunityCards('dealFlop', 3);
    }

    public function testDealTurn()
    {
        $this->doTestDealCommunityCards('dealTurn', 1);
    }

    public function testDealRiver()
    {
        $this->doTestDealCommunityCards('dealRiver', 1);
    }

    public function testMoveButton()
    {
        $dealer = $this->getDealer();
        $table = $dealer->getTable();
        $this->assertFalse($dealer->moveButton());

        // $dealer->setDeck(new StandardDeck());
        $table = new Table('Table1', 6);
        $dealer->setTable($table);
        $this->assertFalse($dealer->moveButton());

        $player1 = new Player('p1');
        $player2 = new Player('p2');
        $player3 = new Player('p3');
        $player4 = new Player('p4');
        $table
            ->addPlayer($player1)
            ->addPlayer($player2)
            ->addPlayer($player3)
            ->addPlayer($player4);

        $this->assertTrue($player1->hasButton());
        $this->assertSame($player2->getSeat(), $dealer->moveButton());
        $this->assertFalse($player1->hasButton());
        $this->assertTrue($player2->hasButton());
    }

    public function testStartNewHand()
    {
        $table = $this->dealer->getTable();

        $player1 = new Player('Player1');
        $player2 = new Player('Player2');
        $table->addPlayer($player1)->addPlayer($player2);

        $this->assertTrue($this->dealer->startNewHand());
    }

    /**
     * Tests the dealFlop, dealTurn and dealRiver functions.
     *
     * @param string $dealerFunction
     * @param int    $cardSize
     */
    private function doTestDealCommunityCards($dealerFunction, $cardSize)
    {
        $dealer = $this->getDealer();
        $table = $dealer->getTable();

        $muckSize = $table->getMuck()->getSize();
        $communityCardsSize = $table->getCommunityCards()->getSize();

        $this->assertTrue($dealer->$dealerFunction());

        $this->assertSame($muckSize + 1, $table->getMuck()->getSize());
        $this->assertSame(
            $communityCardsSize + $cardSize,
            $table->getCommunityCards()->getSize()
        );
    }

    /**
     * Creates a Dealer.
     *
     * @since  {nextRelease}
     *
     * @return Dealer
     */
    private function getDealer()
    {
        $tableFactory = new TableFactory();
        $table = $tableFactory->makeTableWithDealer('Table1', 6);

        return $table->getDealer();
    }
}
