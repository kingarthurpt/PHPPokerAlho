<?php

namespace Tests\Gameplay\Cards;

use TexasHoldemBundle\Gameplay\Cards\Suit;

class SuitTest extends \Tests\BaseTestCase
{
    public function testConstruct()
    {
        $suit = new Suit('hearts');
        $this->assertEquals('hearts', $this->getPropertyValue($suit, 'name'));

        return $suit;
    }

    public function testConstructWithoutArgs()
    {
        $suit = new Suit();
        $this->assertEquals(null, $this->getPropertyValue($suit, 'name'));
    }

    public function testConstructOnlyWithName()
    {
        $suit = new Suit('hearts');
        $this->assertEquals('hearts', $this->getPropertyValue($suit, 'name'));
        $this->assertEquals(null, $this->getPropertyValue($suit, 'symbol'));
    }

    public function testConstructOnlyWithSymbol()
    {
        $suit = new Suit(null, "♥");
        $this->assertEquals(null, $this->getPropertyValue($suit, 'name'));
        $this->assertEquals("♥", $this->getPropertyValue($suit, 'symbol'));
    }

    public function testToString()
    {
        $suit = new Suit('Clubs', '♣');
        $this->assertEquals('♣', $suit);
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Cards\Suit::getName
     *
     * @depends testConstruct
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
     * @covers \TexasHoldemBundle\Gameplay\Cards\Suit::setName
     *
     * @depends testConstruct
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
     * @covers \TexasHoldemBundle\Gameplay\Cards\Suit::getSymbol
     *
     * @depends testConstruct
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
     * @covers \TexasHoldemBundle\Gameplay\Cards\Suit::setSymbol
     *
     * @depends testConstruct
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
     * @covers \TexasHoldemBundle\Gameplay\Cards\Suit::getAbbreviation
     *
     * @depends testConstruct
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
     * @covers \TexasHoldemBundle\Gameplay\Cards\Suit::setAbbreviation
     *
     * @depends testConstruct
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
