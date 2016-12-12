<?php

namespace PHPPokerAlho\Game;

use PHPPokerAlho\Cards\Deck;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Dealer
{
    /**
     * The Dealers's deck
     *
     * @var string
     */
    private $deck;

    /**
     * Constructor
     *
     * @since  {nextRelease}
     *
     * @param  Deck $deck A Deck of Cards
     */
    public function __construct($deck = null)
    {
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
}
