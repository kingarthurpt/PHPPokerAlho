<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Cards\CardCollection;

/**
 * The Muck
 *
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Muck extends CardCollection
{
    /**
     * Overrides the parent function to prevent the default behavior
     *
     * @since  {nextRelease}
     *
     * @return null
     */
    public function getCards()
    {
        return null;
    }

    /**
     * Overrides the parent function to prevent the default behavior
     *
     * @since  {nextRelease}
     *
     * @return null
     */
    public function getItems()
    {
        return null;
    }

    /**
     * Overrides the parent function to prevent the default behavior
     *
     * @since  {nextRelease}
     *
     * @param  int $index The index
     *
     * @return null
     */
    public function getCardAt(int $index)
    {
        return null;
    }

    /**
     * Overrides the parent function to prevent the default behavior
     *
     * @since  {nextRelease}
     *
     * @param  int $index The index
     *
     * @return null
     */
    public function getItemAt(int $index)
    {
        return null;
    }
}
