<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Cards\Suit;
use PHPPokerAlho\Gameplay\Cards\StandardCard;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardCardTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\StandardCard::__toString
     *
     * @since  nextRelease
     */
    public function testToString()
    {
        $card = new StandardCard(10, new Suit('Clubs', '♣'));
        $this->assertEquals('[T♣]', $card);
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\StandardCard::fromString
     *
     * @since  nextRelease
     */
    public function testFromString()
    {
        $this->assertNull(StandardCard::fromString('10c'));

        $card = StandardCard::fromString('Tc');
        $this->assertEquals('[T♣]', $card);
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\StandardCard::toCliOutput
     *
     * @since  nextRelease
     */
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

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\StandardCard::setValue
     *
     * @since  nextRelease
     */
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

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\StandardCard::getFaceValue
     *
     * @since  nextRelease
     */
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

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\StandardCard::setFaceValue
     *
     * @since  nextRelease
     */
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
}
