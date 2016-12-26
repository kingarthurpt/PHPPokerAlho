<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Game\HandStrength;
use PHPPokerAlho\Gameplay\Rules\HandRanking;

/**
 * @since  {nextRelease}
 *
 * @author Flavio Diniz <flavio.diniz@gatewit.com>
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
        $handStrength = new HandStrength(1, array(3), array(9, 8));

        $this->assertEquals(1, $this->getPropertyValue($handStrength, 'ranking'));
        $this->assertEquals(array(3), $this->getPropertyValue($handStrength, 'rankCardValues'));
        $this->assertEquals(array(9, 8), $this->getPropertyValue($handStrength, 'kickers'));

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
                $this->getPropertyValue($handStrength, 'ranking'), $handStrength->getRanking()
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
                $this->getPropertyValue($handStrength, 'rankCardValues'), $handStrength->getRankingCardValues()
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
                $this->getPropertyValue($handStrength, 'kickers'), $handStrength->getKickers()
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
                $handStrength, HandRanking::getName($handStrength->getRanking())
        );
    }
}
