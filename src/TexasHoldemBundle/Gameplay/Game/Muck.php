<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;

/**
 * The Muck.
 */
class Muck extends CardCollection
{
    /**
     * Overrides the parent function to prevent the default behavior.
     */
    public function getCards()
    {
        return null;
    }

    /**
     * Overrides the parent function to prevent the default behavior.
     */
    public function getItems()
    {
        return null;
    }

    /**
     * Overrides the parent function to prevent the default behavior.
     *
     * @param int $index The index
     */
    public function getCardAt(int $index)
    {
        unset($index);

        return null;
    }

    /**
     * Overrides the parent function to prevent the default behavior.
     *
     * @param int $index The index
     */
    public function getItemAt(int $index)
    {
        unset($index);

        return null;
    }
}
