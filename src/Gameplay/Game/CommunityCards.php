<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Cards\Card;
use PHPPokerAlho\Gameplay\Cards\CardCollection;

/**
 * The community cards
 *
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class CommunityCards extends CardCollection
{
    /**
     * Set the flop Cards
     *
     * @since  {nextRelease}
     *
     * @param  CardCollection $cards The flop Cards
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function setFlop(CardCollection $cards)
    {
        if ($cards->getSize() != 3) {
            return false;
        }

        $this->cards[0] = $cards->getCardAt(0);
        $this->cards[1] = $cards->getCardAt(1);
        $this->cards[2] = $cards->getCardAt(2);
        return true;
    }

    /**
     * Get the flop Cards
     *
     * @since  {nextRelease}
     *
     * @return CardCollection|null A CardCollection with the flop Cards
     *                               or null if not defined
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
     * Set the turn Card
     *
     * @since  {nextRelease}
     *
     * @param  Card $card The turn Card
     */
    public function setTurn(Card $card)
    {
        $this->addCard($card);
    }

    /**
     * Get the turn Card
     *
     * @since  {nextRelease}
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
     * Set the river Card
     *
     * @since  {nextRelease}
     *
     * @param  Card $card The river Card
     */
    public function setRiver(Card $card)
    {
        $this->addCard($card);
    }

    /**
     * Get the river Card
     *
     * @since  {nextRelease}
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
