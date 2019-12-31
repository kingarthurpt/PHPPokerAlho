<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\StandardCard;
use TexasHoldemBundle\Gameplay\Game\HandStrength;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;

class HandStrengthTest extends \Tests\BaseTestCase
{
    private $handStrength;

    protected function setUp(): void
    {
        $this->handStrength = new HandStrength(
            HandRanking::TWO_PAIR,
            [StandardCard::ACE, StandardCard::KING],
            [StandardCard::NINE]
        );
    }
    
    public function testConstruct()
    {
        $this->assertEquals(
            HandRanking::TWO_PAIR,
            $this->getPropertyValue($this->handStrength, 'ranking')
        );
        $this->assertEquals(
            [StandardCard::ACE, StandardCard::KING],
            $this->getPropertyValue($this->handStrength, 'rankCardValues')
        );
        $this->assertEquals(
            [StandardCard::NINE],
            $this->getPropertyValue($this->handStrength, 'kickers')
        );
    }

    public function testGetRanking()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->handStrength, 'ranking'),
            $this->handStrength->getRanking()
        );
    }

    public function testGetRankCardValues()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->handStrength, 'rankCardValues'),
            $this->handStrength->getRankingCardValues()
        );
    }

    public function testGetKikers()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->handStrength, 'kickers'),
            $this->handStrength->getKickers()
        );
    }

    public function testToString()
    {
        $this->assertEquals(
            'Two Pair: Aces and Kings. Kickers: Nine.',
            $this->handStrength->__toString()
        );
    }

    public function testGetRankingCardValuesString()
    {
        $handStrength1 = new HandStrength(
            HandRanking::TWO_PAIR,
            [StandardCard::ACE, StandardCard::KING],
            [StandardCard::NINE]
        );
        $this->assertEquals(
            'Aces and Kings',
            $this->invokeMethod($handStrength1, 'getRankingCardValuesString')
        );

        $handStrength2 = new HandStrength(
            HandRanking::FLUSH,
            [
                StandardCard::ACE,
                StandardCard::KING,
                StandardCard::EIGHT,
                StandardCard::FOUR,
                StandardCard::THREE,
            ],
            [
                StandardCard::ACE,
                StandardCard::KING,
                StandardCard::EIGHT,
                StandardCard::FOUR,
                StandardCard::THREE,
            ]
        );
        $this->assertEquals(
            '',
            $this->invokeMethod($handStrength2, 'getRankingCardValuesString')
        );

        $handStrength3 = new HandStrength(
            HandRanking::HIGH_CARD,
            [StandardCard::ACE],
            [
                StandardCard::KING,
                StandardCard::EIGHT,
                StandardCard::FOUR,
                StandardCard::THREE,
            ]
        );
        $this->assertEquals(
            'Ace',
            $this->invokeMethod($handStrength3, 'getRankingCardValuesString')
        );
    }

    public function testKickersToStr()
    {
        $this->assertEquals(
            'Nine',
            $this->invokeMethod($this->handStrength, 'kickersToStr')
        );

        $handStrength2 = new HandStrength(
            HandRanking::ROYAL_FLUSH,
            [
                StandardCard::ACE,
                StandardCard::KING,
                StandardCard::QUEEN,
                StandardCard::JACK,
                StandardCard::TEN,
            ],
            []
        );
        $this->assertEquals(
            '',
            $this->invokeMethod($handStrength2, 'kickersToStr')
        );
    }
}
