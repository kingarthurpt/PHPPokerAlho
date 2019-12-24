<?php

namespace Tests\Gameplay\Cards;

use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Gameplay\Cards\Card;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class CardTest extends \Tests\BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\Card::__construct
     *
     * @since  nextRelease
     */
    public function testConstructWithBothArgs()
    {
        $suit = new Suit('hearts');
        $card = new Card(2, $suit);
        $this->assertEquals($suit, $this->getPropertyValue($card, 'suit'));
        $this->assertEquals(2, $this->getPropertyValue($card, 'value'));

        return $card;
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\Card::__construct
     *
     * @since  nextRelease
     */
    public function testConstructOnlyWithSuit()
    {
        $suit = new Suit('hearts');
        $card = new Card(null, $suit);
        $this->assertEquals($suit, $this->getPropertyValue($card, 'suit'));
        $this->assertEquals(null, $this->getPropertyValue($card, 'value'));
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\Card::__construct
     *
     * @since  nextRelease
     */
    public function testConstructOnlyWithValue()
    {
        $card = new Card(3, null);
        $this->assertEquals(null, $this->getPropertyValue($card, 'suit'));
        $this->assertEquals(3, $this->getPropertyValue($card, 'value'));
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\Card::__toString
     *
     * @since  nextRelease
     */
    public function testToString()
    {
        $card = new Card(10, new Suit('Clubs', '♣'));
        $this->assertEquals('[10♣]', $card);
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\Card::getValue
     *
     * @depends testConstructWithBothArgs
     *
     * @since  nextRelease
     *
     * @param  Card $card The Card
     */
    public function testGetValue(Card $card)
    {
        $this->assertEquals(
            $this->getPropertyValue($card, 'value'),
            $card->getValue()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\Card::setValue
     *
     * @depends testConstructWithBothArgs
     *
     * @since  nextRelease
     *
     * @param  Card $card The Card
     */
    public function testSetValue(Card $card)
    {
        $card->setValue("Clubs");
        $this->assertEquals(
            "Clubs",
            $this->getPropertyValue($card, 'value')
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\Card::getSuit
     *
     * @depends testConstructWithBothArgs
     *
     * @since  nextRelease
     *
     * @param  Card $card The Card
     */
    public function testGetSuit(Card $card)
    {
        $this->assertEquals(
            $this->getPropertyValue($card, 'suit'),
            $card->getSuit()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\Card::setSuit
     *
     * @depends testConstructWithBothArgs
     *
     * @since  nextRelease
     *
     * @param  Card $card The Card
     */
    public function testSetSuit(Card $card)
    {
        $suit = new Suit("Clubs");
        $card->setSuit($suit);
        $this->assertEquals(
            $suit,
            $this->getPropertyValue($card, 'suit')
        );
    }
}
