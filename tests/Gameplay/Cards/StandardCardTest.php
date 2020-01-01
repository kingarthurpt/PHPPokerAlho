<?php

namespace Tests\Gameplay\Cards;

use TexasHoldemBundle\Gameplay\Cards\StandardCard;
use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Stringifier\StandardCardValue;

class StandardCardTest extends \Tests\BaseTestCase
{
    public function testToString()
    {
        $card = new StandardCard(10, new Suit('Clubs', '♣'));
        $this->assertEquals('[T♣]', $card);
    }

    public function testToCliOutput()
    {
        $card = new StandardCard(10, new Suit('Clubs', '♣'));
        $this->assertEquals(
            '<bg=white;fg=black>[T<bg=white;fg=black>♣</>]</>',
            $card->toCliOutput()
        );

        $card->setSuit(new Suit('Diamonds', '♦'));
        $this->assertEquals(
            '<bg=white;fg=black>[T<bg=white;fg=red>♦</>]</>',
            $card->toCliOutput()
        );
    }

    public function testSetValue()
    {
        $card = new StandardCard();
        $this->assertNull($card->setValue(0));
        $this->assertNull($card->setValue(15));
        $this->assertInstanceOf(StandardCard::class, $card->setValue(2));
        $this->assertInstanceOf(StandardCard::class, $card->setValue(13));

        $this->assertEquals(
            13,
            $this->getPropertyValue($card, 'value')
        );
    }

    public function testGetFaceValue()
    {
        $card = new StandardCard(10);
        $this->assertEquals('T', $card->getFaceValue());

        $card->setValue(11);
        $this->assertEquals('J', $card->getFaceValue());

        $card->setValue(12);
        $this->assertEquals('Q', $card->getFaceValue());

        $card->setValue(13);
        $this->assertEquals('K', $card->getFaceValue());

        $card->setValue(14);
        $this->assertEquals('A', $card->getFaceValue());

        $card->setValue(2);
        $this->assertEquals('2', $card->getFaceValue());
    }

    public function testSetFaceValue()
    {
        $card = new StandardCard();
        $card->setFaceValue('T');
        $this->assertEquals('T', $card->getFaceValue());

        $card->setFaceValue('J');
        $this->assertEquals('J', $card->getFaceValue());

        $card->setFaceValue('Q');
        $this->assertEquals('Q', $card->getFaceValue());

        $card->setFaceValue('K');
        $this->assertEquals('K', $card->getFaceValue());

        $card->setFaceValue('A');
        $this->assertEquals('A', $card->getFaceValue());

        $card->setFaceValue('2');
        $this->assertEquals('2', $card->getFaceValue());
    }

    public function testGetName()
    {
        $expectedValues = array(
            1 => "Unknown",
            2 => "Two",
            3 => "Three",
            4 => "Four",
            5 => "Five",
            6 => "Six",
            7 => "Seven",
            8 => "Eight",
            9 => "Nine",
            10 => "Ten",
            11 => "Jack",
            12 => "Queen",
            13 => "King",
            14 => "Ace",
        );

        for ($i = 1; $i < 15; $i++) {
            $standardCardValue = StandardCardValue::getInstance();
            $this->assertEquals($expectedValues[$i], $standardCardValue->stringify($i));
        }
    }
}
