<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\CommunityCards;
use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class CommunityCardsTest extends \Tests\BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\CommunityCards::getFlop
     *
     * @since  nextRelease
     */
    public function testGetFlopWithoutCards()
    {
        $communityCards = new CommunityCards();
        $this->assertNull($communityCards->getFlop());
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\CommunityCards::getFlop
     *
     * @since  nextRelease
     */
    public function testGetFlop()
    {
        $communityCards = new CommunityCards();
        $flop = array(
            0 => new Card(1, new Suit("Clubs")),
            1 => new Card(10, new Suit("Clubs")),
            2 => new Card(13, new Suit("Clubs"))
        );
        $communityCards->addCards($flop);
        $collection = new CardCollection($flop);

        $this->assertEquals($collection, $communityCards->getFlop());
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\CommunityCards::setFlop
     *
     * @since  nextRelease
     */
    public function testSetFlop()
    {
        $communityCards = new CommunityCards();
        $suit = new Suit("Clubs");
        $flop = array(
            0 => new Card(1, $suit),
            1 => new Card(10, $suit),
            2 => new Card(13, $suit)
        );

        $collection = new CardCollection($flop);

        $this->assertTrue($communityCards->setFlop($collection));
        $this->assertEquals(
            $flop,
            $this->getPropertyValue($communityCards, 'items')
        );

        unset($flop[2]);
        $collection2 = new CardCollection($flop);
        $this->assertFalse($communityCards->setFlop($collection2));
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\CommunityCards::getTurn
     *
     * @since  nextRelease
     */
    public function testGetTurn()
    {
        $communityCards = new CommunityCards();
        $this->assertNull($communityCards->getTurn());

        $suit = new Suit("Clubs");
        $cards = array(
            0 => new Card(1, $suit),
            1 => new Card(10, $suit),
            2 => new Card(13, $suit),
            3 => new Card(12, $suit),
        );
        $communityCards->addCards($cards);
        $this->assertEquals(
            new Card(12, $suit),
            $communityCards->getTurn()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\CommunityCards::setTurn
     *
     * @since  nextRelease
     */
    public function testSetTurn()
    {
        $communityCards = new CommunityCards();
        $this->assertNull($communityCards->getTurn());

        $suit = new Suit("Clubs");
        $cards = array(
            0 => new Card(1, $suit),
            1 => new Card(10, $suit),
            2 => new Card(13, $suit)
        );

        $communityCards->addCards($cards);
        $communityCards->setTurn(new Card(12, $suit));
        $this->assertEquals(
            new Card(12, $suit),
            $communityCards->getTurn()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\CommunityCards::getRiver
     *
     * @since  nextRelease
     */
    public function testGetRiver()
    {
        $communityCards = new CommunityCards();
        $this->assertNull($communityCards->getRiver());

        $suit = new Suit("Clubs");
        $cards = array(
            0 => new Card(1, $suit),
            1 => new Card(10, $suit),
            2 => new Card(13, $suit),
            3 => new Card(13, $suit),
            4 => new Card(7, $suit)
        );
        $communityCards->addCards($cards);
        $this->assertEquals(
            new Card(7, $suit),
            $communityCards->getRiver()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\CommunityCards::setRiver
     *
     * @since  nextRelease
     */
    public function testSetRiver()
    {
        $communityCards = new CommunityCards();
        $this->assertNull($communityCards->getRiver());

        $suit = new Suit("Clubs");
        $cards = array(
            0 => new Card(1, $suit),
            1 => new Card(10, $suit),
            2 => new Card(13, $suit),
            3 => new Card(12, $suit)
        );

        $communityCards->addCards($cards);
        $communityCards->setRiver(new Card(4, $suit));
        $this->assertEquals(
            new Card(4, $suit),
            $communityCards->getRiver()
        );
    }
}
