<?php

namespace PHPPokerAlho\Gameplay\Cards;

use PHPPokerAlho\Gameplay\Cards\StandardSuitFactory;

/**
 * A standard Poker Deck
 *
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardDeck extends Deck
{
    /**
     * Constructor
     *
     * @since  {nextRelease}
     */
    public function __construct()
    {
        parent::__construct();

        $suits = array(
            StandardSuitFactory::STD_CLUBS,
            StandardSuitFactory::STD_DIAMONDS,
            StandardSuitFactory::STD_HEARTS,
            StandardSuitFactory::STD_SPADES
        );

        $suitFactory = new StandardSuitFactory();
        foreach ($suits as $suitName) {
            $suit = $suitFactory->create($suitName);

            for ($i = 1; $i <= 13; $i++) {
                $this->addCard(new StandardCard($i, $suit));
            }
        }
    }
}
