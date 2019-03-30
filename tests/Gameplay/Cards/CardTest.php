<?php

namespace Tests;

use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Gameplay\Cards\StandardSuit;
use TexasHoldemBundle\Gameplay\Cards\Card;

class CardTest extends BaseTestCase
{
    public function testConstructWithBothArgs()
    {
        $suit = new Suit(StandardSuit::HEARTS);
        $card = new Card(2, $suit);
        $this->assertSame($suit, $card->getSuit());
        $this->assertSame(2, $card->getValue());

        return $card;
    }

    public function testConstructOnlyWithSuit()
    {
        $suit = new Suit(StandardSuit::HEARTS);
        $card = new Card(null, $suit);
        $this->assertSame($suit, $card->getSuit());
        $this->assertSame(null, $card->getValue());
    }

    public function testConstructOnlyWithValue()
    {
        $card = new Card(3, null);
        $this->assertSame(null, $card->getSuit());
        $this->assertSame(3, $card->getValue());
    }

    public function testToString()
    {
        $value = 10;
        $suit = '♣';
        $expected = sprintf('[%s%s]', $value, $suit);
        $card = new Card($value, new Suit(StandardSuit::CLUBS, $suit));
        $this->assertEquals($expected, $card);
    }

    /**
     * @depends testConstructWithBothArgs
     *
     * @param  Card $card The Card
     */
    public function testGetValue(Card $card)
    {
        $this->assertSame(
            $this->getPropertyValue($card, 'value'),
            $card->getValue()
        );
    }

    /**
     * @depends testConstructWithBothArgs
     *
     * @param  Card $card The Card
     */
    public function testSetValue(Card $card)
    {
        $card->setValue(StandardSuit::CLUBS);
        $this->assertSame(
            StandardSuit::CLUBS,
            $this->getPropertyValue($card, 'value')
        );
    }

    /**
     * @depends testConstructWithBothArgs
     *
     * @param  Card $card The Card
     */
    public function testGetSuit(Card $card)
    {
        $this->assertSame(
            $this->getPropertyValue($card, 'suit'),
            $card->getSuit()
        );
    }

    /**
     * @depends testConstructWithBothArgs
     *
     * @param  Card $card The Card
     */
    public function testSetSuit(Card $card)
    {
        $suit = new Suit(StandardSuit::CLUBS);
        $card->setSuit($suit);
        $this->assertSame(
            $suit,
            $this->getPropertyValue($card, 'suit')
        );
    }
}
