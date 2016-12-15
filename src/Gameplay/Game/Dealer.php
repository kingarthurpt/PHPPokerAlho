<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Cards\Deck;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Dealer extends GameObserver
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
        return $this;
    }

    /**
     * Get a notification about changes in the GameSubject
     *
     * @since  {nextRelease}
     *
     * @param  GameSubject $subject
     */
    public function update(GameSubject $subject)
    {
        // @todo implement later
        return true;
    }

    public function deal()
    {
        if (!$this->hasDeck() || !$this->hasTable()) {
            return false;
        }

        $deck = $this->getDeck();
        $table = $this->getTable();
        $players = $table->getPlayers();

        $deck->shuffle();

        foreach ($players as $player) {
            $holeCards = $deck->drawFromTop(2);
            $player->setHand($holeCards);
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
