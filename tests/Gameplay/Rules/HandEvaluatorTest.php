<?php

namespace Tests;

use TexasHoldemBundle\Gameplay\Cards\StandardCard;
use TexasHoldemBundle\Gameplay\Cards\StandardSuit;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Game\HandStrength;
use TexasHoldemBundle\Gameplay\Rules\HandEvaluator;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class HandEvaluatorTest extends BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::compareHands
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::compareTwoHands
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::compareCardValues
     *
     * @since  nextRelease
     */
    public function testCompareHandsByRanking()
    {
        $evaluator = new HandEvaluator();
        $hand1 = new HandStrength(
            HandRanking::TWO_PAIR,
            array(StandardCard::EIGHT),
            array(StandardCard::SIX, StandardCard::FOUR, StandardCard::THREE)
        );
        $hand2 = new HandStrength(
            HandRanking::ONE_PAIR,
            array(StandardCard::NINE),
            array(StandardCard::SIX, StandardCard::FOUR, StandardCard::THREE)
        );
        $hand3 = new HandStrength(
            HandRanking::THREE_OF_A_KIND,
            array(StandardCard::ACE),
            array(StandardCard::SIX, StandardCard::FOUR, StandardCard::THREE)
        );

        $hands = array($hand1, $hand2, $hand3);
        $result = $evaluator->compareHands($hands);
        $this->assertEquals($hand1, $result[1]);
        $this->assertEquals($hand2, $result[2]);
        $this->assertEquals($hand3, $result[0]);
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::compareHands
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::compareTwoHands
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::compareCardValues
     *
     * @since  nextRelease
     */
    public function testCompareHandsByRankingCardValues()
    {
        $evaluator = new HandEvaluator();
        $hand1 = new HandStrength(
            HandRanking::TWO_PAIR,
            array(StandardCard::NINE, StandardCard::FOUR),
            array(StandardCard::SIX, StandardCard::FOUR, StandardCard::THREE)
        );
        $hand2 = new HandStrength(
            HandRanking::TWO_PAIR,
            array(StandardCard::NINE, StandardCard::SEVEN),
            array(StandardCard::SIX, StandardCard::FOUR, StandardCard::THREE)
        );

        $hands = array($hand1, $hand2);
        $result = $evaluator->compareHands($hands);
        $this->assertEquals($hand1, $result[1]);
        $this->assertEquals($hand2, $result[0]);
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::compareHands
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::compareTwoHands
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::compareCardValues
     *
     * @since  nextRelease
     */
    public function testCompareHandsByKickerCards()
    {
        $evaluator = new HandEvaluator();
        $hand1 = new HandStrength(
            HandRanking::TWO_PAIR,
            array(StandardCard::NINE, StandardCard::FOUR),
            array(StandardCard::SIX, StandardCard::FIVE, StandardCard::THREE)
        );
        $hand2 = new HandStrength(
            HandRanking::TWO_PAIR,
            array(StandardCard::NINE, StandardCard::FOUR),
            array(StandardCard::SIX, StandardCard::FOUR, StandardCard::THREE)
        );
        $hand3 = new HandStrength(
            HandRanking::TWO_PAIR,
            array(StandardCard::NINE, StandardCard::FOUR),
            array(StandardCard::SEVEN, StandardCard::SIX, StandardCard::THREE)
        );

        $hands = array($hand1, $hand2, $hand3);
        $result = $evaluator->compareHands($hands);
        $this->assertEquals($hand1, $result[1]);
        $this->assertEquals($hand2, $result[2]);
        $this->assertEquals($hand3, $result[0]);
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testGetStrength()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ad Kd Qd Jd Td 2s 2c 6h');
        $this->assertNull($evaluator->getStrength($cards));

        $cards = CardCollection::fromString('Ad Kd Qd Jd Td 2s 2c');
        $this->assertEquals(
            HandRanking::ROYAL_FLUSH,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasRoyalFlush
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testHasRoyalFlush()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ad Kd Qd Jd Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasRoyalFlush", array($cards))
        );

        $this->assertEquals(
            HandRanking::ROYAL_FLUSH,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasRoyalFlush
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testInvalidRoyalFlush()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Kd Qd Jd Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasRoyalFlush", array($cards))
        );

        $cards = CardCollection::fromString('2d Kd Qd Jd Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasRoyalFlush", array($cards))
        );

        $this->assertNotEquals(
            HandRanking::ROYAL_FLUSH,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasStraightFlush
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testHasStraightFlush()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Kh Qh Jh Th 9h 2s 2h');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasStraightFlush", array($cards))
        );

        $this->assertEquals(
            HandRanking::STRAIGHT_FLUSH,
            $evaluator->getStrength($cards)->getRanking()
        );

        $cards = CardCollection::fromString('Ac 2c 3c 4c 5c 2s 2h');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasStraightFlush", array($cards))
        );

        $this->assertEquals(
            HandRanking::STRAIGHT_FLUSH,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasStraightFlush
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testInvalidStraightFlush()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('8c 3c 4c 5c 7d 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasStraightFlush", array($cards))
        );

        $this->assertNotEquals(
            HandRanking::STRAIGHT_FLUSH,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasFourOfAKind
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testHasFourOfAKind()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad As Ah Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasFourOfAKind", array($cards))
        );

        $this->assertEquals(
            HandRanking::FOUR_OF_A_KIND,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasFourOfAKind
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testInvalidFourOfAKind()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad As Kh Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasFourOfAKind", array($cards))
        );

        $this->assertNotEquals(
            HandRanking::FOUR_OF_A_KIND,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasFullHouse
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testHasFullHouse()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad As Kh 2h 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasFullHouse", array($cards))
        );

        $this->assertEquals(
            HandRanking::FULL_HOUSE,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasFullHouse
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testInvalidFullHouse()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad Ks Kh Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasFullHouse", array($cards))
        );

        $this->assertNotEquals(
            HandRanking::FULL_HOUSE,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasFlush
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testHasFlush()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac 3c 4c 7c Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasFlush", array($cards))
        );

        $this->assertEquals(
            HandRanking::FLUSH,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasFlush
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testInvalidFlush()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad Ks Kh Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasFlush", array($cards))
        );

        $this->assertNotEquals(
            HandRanking::FLUSH,
            $evaluator->getStrength($cards)->getRanking()
        );
    }


    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasStraight
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testHasStraight()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Kc Qc Js Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasStraight", array($cards))
        );

        $this->assertEquals(
            HandRanking::STRAIGHT,
            $evaluator->getStrength($cards)->getRanking()
        );

        $cards = CardCollection::fromString('Ac 2c 2h 4s 5d 7s 3d');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasStraight", array($cards))
        );

        $this->assertEquals(
            HandRanking::STRAIGHT,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasStraight
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testInvalidStraight()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('8c 3d 4s 5h 7d 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasStraight", array($cards))
        );

        $this->assertNotEquals(
            HandRanking::STRAIGHT,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasThreeOfAKind
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testHasThreeOfAKind()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad As Jd Td 6s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasThreeOfAKind", array($cards))
        );

        $this->assertEquals(
            HandRanking::THREE_OF_A_KIND,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasThreeOfAKind
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testInvalidThreeOfAKind()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad 3s Jd Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasThreeOfAKind", array($cards))
        );

        $this->assertNotEquals(
            HandRanking::THREE_OF_A_KIND,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasTwoPair
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testHasTwoPair()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad Qs Jd Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasTwoPair", array($cards))
        );

        $this->assertEquals(
            HandRanking::TWO_PAIR,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasTwoPair
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testInvalidTwoPair()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad 3s Jd Td 4s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasTwoPair", array($cards))
        );

        $this->assertNotEquals(
            HandRanking::TWO_PAIR,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasOnePair
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testHasOnePair()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad Qs Jd Td 5s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasOnePair", array($cards))
        );

        $this->assertEquals(
            HandRanking::ONE_PAIR,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::hasOnePair
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @since  nextRelease
     */
    public function testInvalidOnePair()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Kd 3s Jd Td 4s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasOnePair", array($cards))
        );

        $this->assertEquals(
            HandRanking::HIGH_CARD,
            $evaluator->getStrength($cards)->getRanking()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Rules\HandEvaluator::countCardOccurrences
     *
     * @since  nextRelease
     */
    public function testCountCardOccurrences()
    {
        $evaluator = new HandEvaluator();
        $cards = CardCollection::fromString('Ac Ad As Ah Kd Ks Kc');

        $occurrences = $this->invokeMethod(
            $evaluator,
            "countCardOccurrences",
            array($cards)
        );

        $this->assertEquals(4, $occurrences[0]);
        $this->assertEquals(3, $occurrences[1]);
    }
}
