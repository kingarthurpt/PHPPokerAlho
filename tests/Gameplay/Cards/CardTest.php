<?php

namespace Tests\Gameplay\Cards;

use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\Suit;

class CardTest extends \Tests\BaseTestCase
{
    public function testConstruct()
    {
        $suit = new Suit('hearts', '♥');
        $card = new Card(2, $suit);
        $this->assertEquals($suit, $card->getSuit());
        $this->assertEquals(2, $card->getValue());

        $this->assertEquals('[2♥]', $card);

        return $card;
    }

    public function testConstructOnlyWithSuit()
    {
        $suit = new Suit('hearts');
        $card = new Card(null, $suit);
        $this->assertEquals($suit, $card->getSuit());
        $this->assertEquals(null, $card->getValue());
    }

    public function testConstructOnlyWithValue()
    {
        $card = new Card(3, null);
        $this->assertEquals(null, $card->getSuit());
        $this->assertEquals(3, $card->getValue());
    }
}
