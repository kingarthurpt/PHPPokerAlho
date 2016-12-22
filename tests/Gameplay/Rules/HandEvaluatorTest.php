<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Cards\StandardCard;
use PHPPokerAlho\Gameplay\Cards\StandardSuit;
use PHPPokerAlho\Gameplay\Cards\CardCollection;
use PHPPokerAlho\Gameplay\Rules\HandEvaluator;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class HandEvaluatorTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        return new HandEvaluator();
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testGetStrength(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ad Kd Qd Jd Td 2s 2c 6h');
        $this->assertEquals(
            -1,
            $evaluator->getStrength($cards)
        );

        $cards = CardCollection::fromString('Ad Kd Qd Jd Td 2s 2c');
        $this->assertEquals(
            HandEvaluator::ROYAL_FLUSH,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasRoyalFlush
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testHasRoyalFlush(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ad Kd Qd Jd Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasRoyalFlush", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::ROYAL_FLUSH,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasRoyalFlush
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testInvalidRoyalFlush(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Kd Qd Jd Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasRoyalFlush", array($cards))
        );

        $cards = CardCollection::fromString('2d Kd Qd Jd Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasRoyalFlush", array($cards))
        );

        $this->assertNotEquals(
            HandEvaluator::ROYAL_FLUSH,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasStraightFlush
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testHasStraightFlush(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Kh Qh Jh Th 9h 2s 2h');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasStraightFlush", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::STRAIGHT_FLUSH,
            $evaluator->getStrength($cards)
        );

        $cards = CardCollection::fromString('Ac 2c 3c 4c 5c 2s 2h');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasStraightFlush", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::STRAIGHT_FLUSH,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasStraightFlush
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testInvalidStraightFlush(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('8c 3c 4c 5c 7d 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasStraightFlush", array($cards))
        );

        $this->assertNotEquals(
            HandEvaluator::STRAIGHT_FLUSH,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasFourOfAKind
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testHasFourOfAKind(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad As Ah Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasFourOfAKind", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::FOUR_OF_A_KIND,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasFourOfAKind
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testInvalidFourOfAKind(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad As Kh Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasFourOfAKind", array($cards))
        );

        $this->assertNotEquals(
            HandEvaluator::FOUR_OF_A_KIND,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasFullHouse
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testHasFullHouse(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad As Kh 2h 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasFullHouse", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::FULL_HOUSE,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasFullHouse
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testInvalidFullHouse(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad Ks Kh Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasFullHouse", array($cards))
        );

        $this->assertNotEquals(
            HandEvaluator::FULL_HOUSE,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasFlush
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testHasFlush(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac 3c 4c 7c Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasFlush", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::FLUSH,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasFlush
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testInvalidFlush(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad Ks Kh Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasFlush", array($cards))
        );

        $this->assertNotEquals(
            HandEvaluator::FLUSH,
            $evaluator->getStrength($cards)
        );
    }


    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasStraight
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testHasStraight(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Kc Qc Js Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasStraight", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::STRAIGHT,
            $evaluator->getStrength($cards)
        );

        $cards = CardCollection::fromString('Ac 2c 2h 4s 5d 7s 3d');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasStraight", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::STRAIGHT,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasStraight
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testInvalidStraight(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('8c 3d 4s 5h 7d 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasStraight", array($cards))
        );

        $this->assertNotEquals(
            HandEvaluator::STRAIGHT,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasThreeOfAKind
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testHasThreeOfAKind(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad As Jd Td 6s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasThreeOfAKind", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::THREE_OF_A_KIND,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasThreeOfAKind
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testInvalidThreeOfAKind(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad 3s Jd Td 2s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasThreeOfAKind", array($cards))
        );

        $this->assertNotEquals(
            HandEvaluator::THREE_OF_A_KIND,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasTwoPair
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testHasTwoPair(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad Qs Jd Td 2s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasTwoPair", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::TWO_PAIR,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasTwoPair
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testInvalidTwoPair(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad 3s Jd Td 4s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasTwoPair", array($cards))
        );

        $this->assertNotEquals(
            HandEvaluator::TWO_PAIR,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasOnePair
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testHasOnePair(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Ad Qs Jd Td 5s 2c');
        $this->assertTrue(
            $this->invokeMethod($evaluator, "hasOnePair", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::ONE_PAIR,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::hasOnePair
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::getStrength
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testInvalidOnePair(HandEvaluator $evaluator)
    {
        $cards = CardCollection::fromString('Ac Kd 3s Jd Td 4s 2c');
        $this->assertFalse(
            $this->invokeMethod($evaluator, "hasOnePair", array($cards))
        );

        $this->assertEquals(
            HandEvaluator::HIGH_CARD,
            $evaluator->getStrength($cards)
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Rules\HandEvaluator::countCardOccurrences
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  HandEvaluator $evaluator The HandEvaluator
     */
    public function testCountCardOccurrences(HandEvaluator $evaluator)
    {
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
