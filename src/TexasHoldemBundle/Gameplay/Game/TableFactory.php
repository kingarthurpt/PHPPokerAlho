<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\TableSubject;
use TexasHoldemBundle\Gameplay\Game\Dealer;
use TexasHoldemBundle\Gameplay\Cards\StandardSuitFactory;
use TexasHoldemBundle\Gameplay\Cards\StandardDeck;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class TableFactory
{
    /**
     * Create a CardCollection from StandardCard's string abbreviation
     * Use a space to separate each card
     *
     * @since  {nextRelease}
     *
     * @param  string $str The StandardCard's string abbreviation
     *
     * @return CardCollection|null
     */
    public function makeTableWithDealer(string $name, int $seats)
    {
        $table = $this->createInstance($name, $seats);

        $suitFactory = new StandardSuitFactory();
        $deck = new StandardDeck($suitFactory);
        new Dealer($deck, $table);

        return $table;
    }

    /**
     * Creates an instance
     *
     * @param string The table name
     * @param int The number of seats
     *
     * @return CardCollection
     */
    private function createInstance(string $name, int $seats)
    {
        return new Table($name, $seats);
    }
}
