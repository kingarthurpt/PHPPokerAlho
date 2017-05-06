<?php

namespace TexasHoldemBundle\Gameplay\Cards;

/**
 * A collection of Cards
 *
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Deck extends CardCollection
{
    /**
     * Shuffle the Deck
     *
     * @since  {nextRelease}
     *
     * @return bool TRUE on success or FALSE on failure
     */
    public function shuffle()
    {
        return shuffle($this->items);
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
        $index = array_rand($this->items, 1);
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

        foreach ($this->items as $key => $value) {
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
     * @return Card|CardCollection|null A Card if $amount = 1
     *                                  A CardCollection if $amout > 1
     *                                  or null if deck size < $amount
     */
    public function drawFromTop(int $amount)
    {
        if ($this->getSize() < $amount) {
            return null;
        }

        $result = array_splice($this->items, 0, $amount);
        if ($amount == 1) {
            return $result[0];
        }

        return new CardCollection($result);
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
        if (!isset($this->items[$index])) {
            return null;
        }

        $result = array_splice($this->items, $index, 1);
        return is_array($result) ? reset($result) : $result;
    }
}
