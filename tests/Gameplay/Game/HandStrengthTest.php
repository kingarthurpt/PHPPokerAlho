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
            'Two Pair: Ace and King. Kickers: Nine.',
            $this->handStrength->__toString()
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

    public function testGetValue()
    {
        $twoPairAcesKings = new HandStrength(
            HandRanking::TWO_PAIR,
            [StandardCard::ACE, StandardCard::KING],
            [StandardCard::NINE]
        );
        $this->assertEquals(12729, $twoPairAcesKings->getValue());

        $pairAces = new HandStrength(
            HandRanking::ONE_PAIR,
            [StandardCard::ACE],
            []
        );
        $this->assertEquals(736, $pairAces->getValue());

        $threeTwosAcesKick = new HandStrength(
            HandRanking::THREE_OF_A_KIND,
            [StandardCard::TWO],
            [StandardCard::ACE, StandardCard::TWO]
        );
        $this->assertTrue($threeTwosAcesKick->getValue() > $pairAces->getValue());

        $threeTwosThreeKick = new HandStrength(
            HandRanking::THREE_OF_A_KIND,
            [StandardCard::TWO],
            [StandardCard::THREE, StandardCard::FOUR]
        );
        $this->assertTrue($threeTwosAcesKick->getValue() > $threeTwosThreeKick->getValue());
    }
}
