<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Cards\Deck;
use PHPPokerAlho\Gameplay\Cards\CardCollection;

/**
 * A Poker Dealer
 *
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
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
     * @since  {nextRelease}
     *
     * @param  Deck $deck A Deck of Cards
     */
    public function __construct($deck = null)
    {
        $this->deck = null;
        $this->table = null;

        if (!is_null($deck)) {
            $this->setDeck($deck);
        }
    }

    /**
     * Get the Dealer's deck
     *
     * @since  {nextRelease}
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
     * @since  {nextRelease}
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
     * @since  {nextRelease}
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
     * @since  {nextRelease}
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
     * @since  {nextRelease}
     *
     * @param  TableSubject $subject
     * @param  TableEvent $event The Event being fired
     */
    public function update(TableSubject $subject, TableEvent $event)
    {
        return true;
    }

    /**
     * Deal cards to each Player seated at the Table
     *
     * @since  {nextRelease}
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function deal()
    {
        if (!$this->hasDeck() || !$this->hasTable()) {
            return false;
        }

        $deck = $this->getDeck();
        $table = $this->getTable();
        $players = $table->getPlayers();

        // Return each player's hands back into the deck
        foreach ($players as $player) {
            $hand = $player->returnHand();
            if (!is_null($hand)) {
                $deck->addCards($hand->getHand());
            }
        }

        $deck->addCards($table->getMuck()->removeCards());
        $deck->shuffle();

        foreach ($players as $player) {
            $hand = new CardCollection($deck->drawFromTop(2), 2);
            $player->setHand($hand);
        }

        // Notify the Players
        // $table->notify();

        return true;
    }

    /**
     * Checks if the Dealer has a Deck
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasDeck()
    {
        return $this->deck instanceof Deck;
    }

    /**
     * Checks if the Dealer has a Table
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return bool TRUE on success, FALSE on failure
     */
    private function hasTable()
    {
        return $this->table instanceof Table;
    }
}
