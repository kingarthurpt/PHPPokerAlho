<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Game\HandStrength;
use PHPPokerAlho\Gameplay\Rules\HandRanking;
use PHPPokerAlho\Gameplay\Cards\StandardCard;

/**
 * @since  nextRelease
 *
 * @author Flávio Diniz <f.diniz14@gmail.com>
 */
class HandStrengthTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Game\HandStrength::__construct()
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $handStrength = new HandStrength(
            HandRanking::TWO_PAIR,
            array(StandardCard::ACE, StandardCard::KING),
            array(StandardCard::NINE)
        );

        $this->assertEquals(
            HandRanking::TWO_PAIR,
            $this->getPropertyValue($handStrength, 'ranking')
        );
        $this->assertEquals(
            array(StandardCard::ACE, StandardCard::KING),
            $this->getPropertyValue($handStrength, 'rankCardValues')
        );
        $this->assertEquals(
            array(StandardCard::NINE),
            $this->getPropertyValue($handStrength, 'kickers')
        );

        return $handStrength;
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\HandStrength::getRanking()
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandStrength $handStrength The Hand strength
     */
    public function testGetRanking(HandStrength $handStrength)
    {
        $this->assertEquals(
            $this->getPropertyValue($handStrength, 'ranking'),
            $handStrength->getRanking()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\HandStrength::getRankingCardValues()
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandStrength $handStrength The Hand strength
     */
    public function testGetRankCardValues(HandStrength $handStrength)
    {
        $this->assertEquals(
            $this->getPropertyValue($handStrength, 'rankCardValues'),
            $handStrength->getRankingCardValues()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\HandStrength::getKickers()
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandStrength $handStrength The Hand strength
     */
    public function testGetKikers(HandStrength $handStrength)
    {
        $this->assertEquals(
            $this->getPropertyValue($handStrength, 'kickers'),
            $handStrength->getKickers()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\HandStrength::__toString()
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandStrength $handStrength The Hand strength
     */
    public function testToString(HandStrength $handStrength)
    {
        $this->assertEquals(
            "Two Pair: Aces and Kings. Kickers: Nine.",
            $handStrength->__toString()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\HandStrength::rankingToStr()
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandStrength $handStrength The Hand strength
     */
    public function testRankingToStr(HandStrength $handStrength)
    {
        $this->assertEquals(
            "Two Pair: ",
            $this->invokeMethod($handStrength, "rankingToStr")
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\HandStrength::getRankingCardValuesString()
     * @covers \PHPPokerAlho\Gameplay\Game\HandStrength::rankingCardValuesToStr()
     *
     * @since  nextRelease
     */
    public function testGetRankingCardValuesString()
    {
        $handStrength1 = new HandStrength(
            HandRanking::TWO_PAIR,
            array(StandardCard::ACE, StandardCard::KING),
            array(StandardCard::NINE)
        );
        $this->assertEquals(
            "Aces and Kings. ",
            $this->invokeMethod($handStrength1, "getRankingCardValuesString")
        );

        $handStrength2 = new HandStrength(
            HandRanking::FLUSH,
            array(
                StandardCard::ACE,
                StandardCard::KING,
                StandardCard::EIGHT,
                StandardCard::FOUR,
                StandardCard::THREE
            ),
            array(
                StandardCard::ACE,
                StandardCard::KING,
                StandardCard::EIGHT,
                StandardCard::FOUR,
                StandardCard::THREE
            )
        );
        $this->assertEquals(
            "",
            $this->invokeMethod($handStrength2, "getRankingCardValuesString")
        );

        $handStrength3 = new HandStrength(
            HandRanking::HIGH_CARD,
            array(StandardCard::ACE),
            array(
                StandardCard::KING,
                StandardCard::EIGHT,
                StandardCard::FOUR,
                StandardCard::THREE
            )
        );
        $this->assertEquals(
            "Ace. ",
            $this->invokeMethod($handStrength3, "getRankingCardValuesString")
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\HandStrength::kickersToStr()
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandStrength $handStrength The Hand strength
     */
    public function testKickersToStr(HandStrength $handStrength)
    {
        $this->assertEquals(
            "Kickers: Nine.",
            $this->invokeMethod($handStrength, "kickersToStr")
        );

        $handStrength2 = new HandStrength(
            HandRanking::ROYAL_FLUSH,
            array(
                StandardCard::ACE,
                StandardCard::KING,
                StandardCard::QUEEN,
                StandardCard::JACK,
                StandardCard::TEN
            ), 
            array()
        );
        $this->assertEquals(
            "",
            $this->invokeMethod($handStrength2, "kickersToStr")
        );
    }
}
