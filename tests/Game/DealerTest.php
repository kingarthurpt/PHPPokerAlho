<?php

namespace Tests;

use PHPPokerAlho\Cards\Deck;
use PHPPokerAlho\Cards\StandardDeck;
use PHPPokerAlho\Game\Dealer;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class DealerTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Game\Dealer::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $deck = new StandardDeck();
        $dealer = new Dealer($deck);
        $this->assertEquals($deck, $this->getPropertyValue($dealer, 'deck'));

        return $dealer;
    }

    /**
     * @covers \PHPPokerAlho\Game\Dealer::__construct
     *
     * @since  nextRelease
     */
    public function testConstructWithoutArgs()
    {
        $dealer = new Dealer();
        $this->assertNull($this->getPropertyValue($dealer, 'deck'));
    }

    /**
     * @covers \PHPPokerAlho\Game\Dealer::getDeck
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Dealer $dealer The Dealer
     */
    public function testGetDeck(Dealer $dealer)
    {
        $this->assertEquals(
            $this->getPropertyValue($dealer, 'deck'),
            $dealer->getDeck()
        );
    }

    /**
     * @covers \PHPPokerAlho\Game\Dealer::setDeck
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Dealer $dealer The Dealer
     */
    public function testSetDeck(Dealer $dealer)
    {
        $deck = new Deck();
        $dealer->setDeck($deck);
        $this->assertEquals(
            $deck,
            $this->getPropertyValue($dealer, 'deck')
        );
    }
}
