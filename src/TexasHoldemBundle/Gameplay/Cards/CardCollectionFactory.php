<?php

namespace TexasHoldemBundle\Gameplay\Cards;

use TexasHoldemBundle\DesignPatterns\Collection;

class CardCollectionFactory extends Collection
{
    /**
     * @param StandardCardFactory
     */
    private $cardFactory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cardFactory = new StandardCardFactory();
    }

    /**
     * Create a CardCollection from StandardCard's string abbreviation
     * Use a space to separate each card
     *
     * @param  string $str The StandardCard's string abbreviation
     *
     * @return CardCollection|null
     */
    public function makeFromString(string $str)
    {
        $cardsStr = explode(" ", $str);

        return $this->createInstance($cardsStr);
    }

    /**
     * Creates an instance
     *
     * @param array String representation of each card
     *
     * @return CardCollection
     */
    private function createInstance(array $cardsStr)
    {
        $instance = new CardCollection();
        foreach ($cardsStr as $cardStr) {
            $card = $this->cardFactory->makeFromString($cardStr);
            if (is_null($card)) {
                return null;
            }

            $instance->addCard($card);
        }

        return $instance;
    }
}
