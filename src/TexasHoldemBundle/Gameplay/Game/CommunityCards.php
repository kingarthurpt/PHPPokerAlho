<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;

/**
 * The community cards.
 */
class CommunityCards extends CardCollection
{
    /**
     * Set the flop Cards.
     *
     * @param CardCollection $cards The flop Cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function setFlop(CardCollection $cards)
    {
        if (3 != $cards->getSize()) {
            return false;
        }

        $this->items[0] = $cards->getCardAt(0);
        $this->items[1] = $cards->getCardAt(1);
        $this->items[2] = $cards->getCardAt(2);

        return true;
    }

    /**
     * Get the flop Cards.
     *
     * @return CardCollection|null A CardCollection with the flop Cards
     *                             or null if not defined
     */
    public function getFlop()
    {
        if ($this->getSize() < 3) {
            return null;
        }

        $cards = new CardCollection();
        $cards->addCard($this->getCardAt(0));
        $cards->addCard($this->getCardAt(1));
        $cards->addCard($this->getCardAt(2));

        return $cards;
    }

    /**
     * Set the turn Card.
     *
     * @param Card $card The turn Card
     */
    public function setTurn(Card $card)
    {
        $this->addCard($card);
    }

    /**
     * Get the turn Card.
     *
     * @return Card The turn Card  or null if not defined
     */
    public function getTurn()
    {
        if ($this->getSize() < 4) {
            return null;
        }

        return $this->getCardAt(3);
    }

    /**
     * Set the river Card.
     *
     * @param Card $card The river Card
     */
    public function setRiver(Card $card)
    {
        $this->addCard($card);
    }

    /**
     * Get the river Card.
     *
     * @return Card|null The river Card or null if not defined
     */
    public function getRiver()
    {
        if ($this->getSize() < 5) {
            return null;
        }

        return $this->getCardAt(4);
    }
}
