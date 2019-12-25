<?php

namespace TexasHoldemBundle\Gameplay\Cards;

use TexasHoldemBundle\DataStructures\Collection;

class CardCollection extends Collection
{
    /**
     * Return a string representation of the CardCollection.
     *
     * @return string The CardCollection represented as a string
     */
    public function __toString()
    {
        if (empty($this->items)) {
            return '';
        }

        $result = '';
        $count = count($this->items);
        for ($i = 0; $i < $count; ++$i) {
            $result .= $this->items[$i]->__toString();
        }

        return $result;
    }

    /**
     * Return a string representation of the CardCollection, formated with CLI colors.
     *
     * @return string The CardCollection represented as a string
     */
    public function toCliOutput()
    {
        $result = '';
        $count = count($this->items);
        for ($i = 0; $i < $count; ++$i) {
            if (!$this->items[$i] instanceof StandardCard) {
                return $this->__toString();
            }

            $result .= $this->items[$i]->toCliOutput();
        }

        return $result;
    }

    /**
     * Get the array of Cards.
     *
     * @return array The array of Cards
     */
    public function getCards()
    {
        return $this->getItems();
    }

    /**
     * Get the Card at a given index.
     *
     * @param int $index The index
     *
     * @return Card The Card at the given index
     */
    public function getCardAt(int $index)
    {
        return $this->getItemAt($index);
    }

    /**
     * Set the array of Cards.
     *
     * @param array $cards The collection of Cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function setCards(array $cards)
    {
        $count = count($cards);
        // Each array element must be a Card
        for ($i = 0; $i < $count; ++$i) {
            if (!$cards[$i] instanceof Card) {
                return false;
            }
        }

        $this->setItems($cards);

        return true;
    }

    /**
     * Add a Card to the CardCollection.
     *
     * @param Card $card The Card to be added to the CardCollection
     */
    public function addCard(Card $card)
    {
        if (in_array($card, $this->items)) {
            return null;
        }

        return $this->addItem($card);
    }

    /**
     * Add an array of Cards to the CardCollection.
     *
     * @param array $cards The Cards to add
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

        return $this->addItems($cards);
    }

    /**
     * Add an array of Cards to the CardCollection.
     *
     * @param CardCollection $cards The CardCollection to add
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function mergeCards(CardCollection $cards)
    {
        return $this->merge($cards);
    }

    /**
     * Remove and get all Cards in the collection.
     *
     * @return array The collection Cards
     */
    public function removeCards()
    {
        return $this->removeItems();
    }
}
