<?php

namespace TexasHoldemBundle\Gameplay\Cards;

/**
 * A standard Poker Card
 *
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardCardFactory extends Card
{
    /**
     * @param StandardSuitFactory
     */
    private $suitFactory;

    public function __construct()
    {
        $this->suitFactory = new StandardSuitFactory();
    }

    /**
     * Create a StandardCard from their value and Suit
     *
     * @param string|int   $value The card's value or facevalue
     * @param StandardSuit $suit The card's suit
     *
     * @return StandardCard
     */
    public function make($value, StandardSuit $suit)
    {
        return $this->createInstance($value, $suit);
    }

    /**
     * Create a StandardCard from their face value and Suit name abbreviation
     *
     * @since  {nextRelease}
     *
     * @param  string $str The StandardCard's face value and Suit's abbreviation
     *
     * @return StandardCard|null
     */
    public function makeFromString(string $str)
    {
        if (strlen($str) != 2) {
            return null;
        }

        return $this->createInstance(
            $str[0],
            $this->suitFactory->makeFromAbbr($str[1])
        );
    }

    /**
     * Creates an instance
     *
     * @param string|int   $value The card's value or facevalue
     * @param StandardSuit $suit The card's suit
     *
     * @return StandardCard
     */
    private function createInstance($value, StandardSuit $suit)
    {
        $instance = new StandardCard();
        $method = is_int($value) ? "setValue" : "setFaceValue";
        $instance->$method($value);
        $instance->setSuit($suit);

        return $instance;
    }
}
