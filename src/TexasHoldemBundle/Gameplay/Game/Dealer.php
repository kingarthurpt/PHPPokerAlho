<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\Deck;

/**
 * A Poker Dealer
 */
class Dealer extends TableObserver
{
    /**
     * The Dealers's deck
     *
     * @var string
     */
    private $deck;

    /**
     * The Dealer's Table
     *
     * @var Table
     */
    private $table;

    /**
     * Constructor
     *
     * @param  Deck $deck A Deck of Cards
     */
    public function __construct(Deck $deck, Table $table)
    {
        $this->table = null;

        $this->setDeck($deck);
        $this->setTable($table);
    }

    /**
     * Get the Dealer's deck
     *
     * @return Deck|null The Dealer's deck
     */
    public function getDeck()
    {
        return $this->deck;
    }

    /**
     * Set the Dealer's deck
     *
     * @param  Deck $deck A Deck of Cards
     *
     * @return Dealer
     */
    public function setDeck(Deck $deck)
    {
        $this->deck = $deck;
        return $this;
    }

    /**
     * Get the Dealer's Table
     *
     * @return Table|null The Dealer's Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Set the Dealer's Table
     *
     * @param  Table $table A Table
     *
     * @return Dealer
     */
    public function setTable(Table $table)
    {
        $this->table = $table;
        $table->setDealer($this);
        return $this;
    }

    /**
     * Get a notification about changes in the TableSubject
     *
     * @param  TableSubject $subject
     * @param  TableEvent $event The Event being fired
     */
    public function update(TableSubject $subject, TableEvent $event)
    {
        unset($subject, $event);

        return true;
    }

    public function startNewHand()
    {
        $table = $this->getTable();
        $players = $table->getPlayers();

        $hand = new Hand();
        $hand
            ->setTable($table)
            ->setPlayers($players)
            ->setSmallBlind(10)
            ->setBigBlind(20);

        $buttonSeat = $this->moveButton();
        $smallBlindSeat = $this->getNextPlayerSeat($buttonSeat);
        $bigBlindSeat = $this->getNextPlayerSeat($smallBlindSeat);
        $nextPlayer = $this->getNextPlayerSeat($bigBlindSeat);

        $players[$smallBlindSeat]->getPlayerActions()->paySmallBlind(10);
        $players[$bigBlindSeat]->getPlayerActions()->payBigBlind(20);

        $this->deal();

        $players[$nextPlayer]->getPlayerActions()->update(
            $this->getTable(),
            new TableEvent(
                TableEvent::PLAYER_ACTION_NEEDED,
                "It's your turn $players[$nextPlayer]->getName()"
            )
        );

        return true;
    }

    /**
     * Deal cards to each Player seated at the Table
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function deal()
    {
        $deck = $this->getDeck();
        $table = $this->getTable();
        $players = $table->getPlayers();

        // Return each player's hands back into the deck
        foreach ($players as $player) {
            $hand = $player->getPlayerActions()->returnHand();
            if (!is_null($hand)) {
                $deck->addCards($hand->getCards());
            }
        }

        $deck->addCards($table->getMuck()->removeCards());
        $deck->shuffle();

        foreach ($players as $player) {
            $player->setHand($deck->drawFromTop(2));
            $player->getPlayerActions()->update(
                $table,
                new TableEvent(TableEvent::PLAYER_RECEIVED_CARDS)
            );
        }

        return true;
    }

    /**
     * Deal the flop
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function dealFlop()
    {
        $deck = $this->getDeck();
        $table = $this->getTable();

        // Muck a card
        $table->getMuck()->addCard($deck->drawFromTop(1));

        // Deal the flop
        $table->getCommunityCards()->setFlop($deck->drawFromTop(3));

        return true;
    }

    /**
     * Deal the turn
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function dealTurn()
    {
        $deck = $this->getDeck();
        $table = $this->getTable();

        // Muck a card
        $table->getMuck()->addCard($deck->drawFromTop(1));

        // Deal the turn
        $table->getCommunityCards()->setTurn($deck->drawFromTop(1));

        return true;
    }

    /**
     * Deal the river
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function dealRiver()
    {
        $deck = $this->getDeck();
        $table = $this->getTable();

        // Muck a card
        $table->getMuck()->addCard($deck->drawFromTop(1));

        // Deal the river
        $table->getCommunityCards()->setTurn($deck->drawFromTop(1));

        return true;
    }

    public function moveButton()
    {
        $players = $this->getTable()->getPlayers();
        if (count($players) <= 1) {
            return false;
        }

        $playerWithButton = $this->getTable()->getSeatOfPlayerWithButton();

        $nextSeat = $this->getNextPlayerSeat($playerWithButton);
        $nextPlayer = $players[$nextSeat];
        $players[$playerWithButton]->setButton(false);
        $nextPlayer->setButton(true);

        return $nextSeat;
    }

    private function getNextPlayerSeat(int $seat)
    {
        $table = $this->getTable();
        $seats = $table->getSeatsCount();
        $players = $table->getPlayers();

        $nextSeat = 0;
        for ($i = $seat + 1; $i < $seats; $i++) {
            if (isset($players[($seat + $i) % $seats])) {
                $nextSeat = ($seat + $i) % $seats;
                break;
            }
        }
        return $nextSeat;
    }
}
