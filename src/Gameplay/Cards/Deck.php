<?php

namespace PHPPokerAlho\Gameplay\Cards;

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
    protected $cards;

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
     * Add an array of Cards to the Deck
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @param  array $cards The Cards to add
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function addCards(array $cards)
    {
        if (empty($cards)) {
            return false;
        }

        foreach ($cards as $key => $value) {
            if (!$value instanceof Card) {
                unset($cards[$key]);
            }
        }

        $this->cards = array_merge($this->cards, $cards);
        return true;
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
     * @return bool TRUE on success or FALSE on failure
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
        return $this->drawCardAt($index);
    }

    /**
     * Draw a Card from the Deck
     *
     * @since  {nextRelease}
     *
     * @param  Card $card The Card to be drawn from the Deck
     *
     * @return bool TRUE in success, FALSE if there was an error
     */
    public function drawCard(Card $card)
    {
        if ($this->getSize() == 0) {
            return false;
        }

        foreach ($this->cards as $key => $value) {
            if ($value == $card) {
                $card = $this->drawCardAt($key);
                return true;
            }
        }

        return false;
    }

    /**
     * Draw the first $amount of Cards
     *
     * @since  {nextRelease}
     *
     * @param  int $amount The Card's index
     *
     * @return array An array of Cards or an empty array if deck size < $amount
     */
    public function drawFromTop(int $amount)
    {
        if ($this->getSize() < $amount) {
            return array();
        }

        $result = array_splice($this->cards, 0, $amount);
        return $result;
    }

    /**
     * Draw the Card at the given index
     *
     * @since  {nextRelease}
     *
     * @param  int $index The Card's index
     *
     * @return Card|null The Card at the given index or null in case of error
     */
    private function drawCardAt(int $index)
    {
        if (!isset($this->cards[$index])) {
            return null;
        }

        $result = array_splice($this->cards, $index, 1);
        return is_array($result) ? reset($result) : $result;
    }
}
