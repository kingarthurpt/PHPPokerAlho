<?php

namespace PHPPokerAlho\Gameplay\Cards;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class CardCollection
{
    /**
     * An array of Cards
     *
     * @var array
     */
    protected $cards = array();

    /**
     * Constructor
     *
     * @since  {nextRelease}
     *
     * @param  array $cards The Cards
     */
    public function __construct(array $cards = array())
    {
        if (!empty($cards)) {
            $this->setCards($cards);
        }
    }

    /**
     * Return a string representation of the CardCollection
     *
     * @since  {nextRelease}
     *
     * @return string The CardCollection represented as a string
     */
    public function __toString()
    {
        if (empty($this->cards)) {
            return "";
        }

        $result = "";
        for ($i = 0; $i < count($this->cards); $i++) {
            $result .= $this->cards[$i]->__toString();
        }
        return $result;
    }

    /**
     * Return a string representation of the CardCollection, formated with CLI colors
     *
     * @since  {nextRelease}
     *
     * @return string The CardCollection represented as a string
     */
    public function toCliOutput()
    {
        $result = "";
        for ($i = 0; $i < count($this->cards); $i++) {
            if (!$this->cards[$i] instanceof StandardCard) {
                return $this->__toString();
            }

            $result .= $this->cards[$i]->toCliOutput();
        }

        return $result;
    }

    /**
     * Get the array of Cards
     *
     * @since  {nextRelease}
     *
     * @return array The array of Cards
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Get the Card at a given index
     *
     * @since  {nextRelease}
     *
     * @param  int $index The index
     *
     * @return Card The Card at the given index
     */
    public function getCardAt(int $index)
    {
        return isset($this->cards[$index]) ? $this->cards[$index] : null;
    }

    /**
     * Set the array of Cards
     *
     * @since  {nextRelease}
     *
     * @param  array $cards The collection of Cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function setCards(array $cards)
    {
        // Each array element must be a Card
        for ($i = 0; $i < count($cards); $i++) {
            if (!$cards[$i] instanceof Card) {
                return false;
            }
        }

        $this->cards = $cards;
        return true;
    }

    /**
     * Add a Card to the CardCollection
     *
     * @since  {nextRelease}
     *
     * @param  Card $card The Card to be added to the CardCollection
     */
    public function addCard(Card $card)
    {
        if (in_array($card, $this->cards)) {
            return null;
        }

        $this->cards[] = $card;
        return $this;
    }

    /**
     * Add an array of Cards to the CardCollection
     *
     * @since  {nextRelease}
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
     * Get the CardCollection's size
     *
     * @since  {nextRelease}
     *
     * @return int The CardCollection's size
     */
    public function getSize()
    {
        return count($this->cards);
    }

    /**
     * Remove and get all Cards in the collection
     *
     * @since  {nextRelease}
     *
     * @return array The collection Cards
     */
    public function removeCards()
    {
        $cards = $this->cards;
        $this->cards = array();
        return $cards;
    }
}
