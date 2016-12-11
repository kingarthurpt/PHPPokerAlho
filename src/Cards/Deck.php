<?php

namespace PHPPokerAlho\Cards;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Deck
{
    /**
     * The Deck's cards
     *
     * @var array
     */
    private $cards;

    /**
     * Constructor
     *
     * @since  {nextRelease}
     */
    public function __construct()
    {
        $this->cards = array();
    }

    /**
     * Add a Card to the Deck
     *
     * @since  {nextRelease}
     *
     * @param  Card $card The Card to be added to the Deck
     */
    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }

    /**
     * Get the Deck's size
     *
     * @since  {nextRelease}
     *
     * @return int The Deck's size
     */
    public function getSize()
    {
        return count($this->cards);
    }

    /**
     * Shuffle the Deck
     *
     * @since  {nextRelease}
     *
     * @return TRUE on success or FALSE on failure
     */
    public function shuffle()
    {
        return shuffle($this->cards);
    }

    /**
     * Draw a random Card from the Deck
     *
     * @since  {nextRelease}
     *
     * @return Card|null A random Card or null if the Deck is empty
     */
    public function drawRandomCard()
    {
        if ($this->getSize() == 0) {
            return null;
        }
        $index = array_rand($this->cards, 1);
        $result = array_splice($this->cards, $index, 1);
        return reset($result);
    }
}
