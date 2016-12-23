<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Cards\Suit;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class SuitTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $suit = new Suit('hearts');
        $this->assertEquals('hearts', $this->getPropertyValue($suit, 'name'));

        return $suit;
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::__construct
     *
     * @since  nextRelease
     */
    public function testConstructWithoutArgs()
    {
        $suit = new Suit();
        $this->assertEquals(null, $this->getPropertyValue($suit, 'name'));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::__construct
     *
     * @since  nextRelease
     */
    public function testConstructOnlyWithName()
    {
        $suit = new Suit('hearts');
        $this->assertEquals('hearts', $this->getPropertyValue($suit, 'name'));
        $this->assertEquals(null, $this->getPropertyValue($suit, 'symbol'));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::__construct
     *
     * @since  nextRelease
     */
    public function testConstructOnlyWithSymbol()
    {
        $suit = new Suit(null, "♥");
        $this->assertEquals(null, $this->getPropertyValue($suit, 'name'));
        $this->assertEquals("♥", $this->getPropertyValue($suit, 'symbol'));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::__toString
     *
     * @since  nextRelease
     */
    public function testToString()
    {
        $suit = new Suit('Clubs', '♣');
        $this->assertEquals('♣', $suit);
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::getName
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Suit $suit The Suit
     */
    public function testGetName(Suit $suit)
    {
        $this->assertEquals(
            $this->getPropertyValue($suit, 'name'),
            $suit->getName()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::setName
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Suit $suit The Suit
     */
    public function testSetName(Suit $suit)
    {
        $suit->setName("Clubs");
        $this->assertEquals(
            "Clubs",
            $this->getPropertyValue($suit, 'name')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::getSymbol
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Suit $suit The Suit
     */
    public function testGetSymbol(Suit $suit)
    {
        $this->assertEquals(
            $this->getPropertyValue($suit, 'symbol'),
            $suit->getSymbol()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::setSymbol
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Suit $suit The Suit
     */
    public function testSetSymbol(Suit $suit)
    {
        $suit->setSymbol('♣');
        $this->assertEquals(
            '♣',
            $this->getPropertyValue($suit, 'symbol')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::getAbbreviation
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Suit $suit The Suit
     */
    public function testGetAbbreviation(Suit $suit)
    {
        $this->assertEquals(
            $this->getPropertyValue($suit, 'abbreviation'),
            $suit->getAbbreviation()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Suit::setAbbreviation
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Suit $suit The Suit
     */
    public function testSetAbbreviation(Suit $suit)
    {
        $suit->setAbbreviation('c');
        $this->assertEquals(
            'c',
            $this->getPropertyValue($suit, 'abbreviation')
        );
    }
}
