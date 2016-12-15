<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Cards\Deck;
use PHPPokerAlho\Gameplay\Cards\Card;
use PHPPokerAlho\Gameplay\Cards\Suit;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class DeckTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $deck = new Deck();
        $this->assertEquals(array(), $this->getPropertyValue($deck, 'cards'));

        return $deck;
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::addCard
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testAddCard(Deck $deck)
    {
        $card = new Card(3, new Suit("Clubs"));
        $this->assertNotContains(
            $card,
            $this->getPropertyValue($deck, 'cards')
        );

        $deck->addCard($card);
        $this->assertContains(
            $card,
            $this->getPropertyValue($deck, 'cards')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::addCards
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testAddCards(Deck $deck)
    {
        $this->assertFalse($deck->addCards(array()));

        $cards = array(
            0 => new Card(4, new Suit("Clubs")),
            1 => new Card(5, new Suit("Diamonds"))
        );

        foreach ($cards as $card) {
            $this->assertNotContains(
                $card,
                $this->getPropertyValue($deck, 'cards')
            );
        }

        $this->assertTrue($deck->addCards($cards));

        foreach ($cards as $card) {
            $this->assertContains(
                $card,
                $this->getPropertyValue($deck, 'cards')
            );
        }
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::getSize
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testGetSize(Deck $deck)
    {
        $this->assertEquals(
            count($this->getPropertyValue($deck, 'cards')),
            $deck->getSize()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::shuffle
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testShuffle(Deck $deck)
    {
        $deck->addCard(new Card(10, new Suit('Spades')));
        $deck->addCard(new Card(5, new Suit('Hearts')));

        // Performs a deep copy of $deck into $deckBeforeShuffling
        $deckBeforeShuffling = array();
        foreach ($deck as $key => $value) {
            $deckBeforeShuffling[$key] = clone $value;
        }

        $this->assertTrue($deck->shuffle());

        $this->assertNotEquals(
            $deckBeforeShuffling,
            $deck
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::drawRandomCard
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawRandomCard(Deck $deck)
    {
        $deck->addCard(new Card(5, new Suit('Hearts')));
        $initialSize = $deck->getSize();

        $card = $deck->drawRandomCard();
        $this->assertInstanceOf(Card::class, $card);

        $this->assertEquals(
            $initialSize - 1,
            $deck->getSize()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::drawRandomCard
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawRandomCardWithEmptyDeck(Deck $deck)
    {
        // Remove all cards from deck
        while ($deck->getSize() > 0) {
            $card = $deck->drawRandomCard();
            $this->assertInstanceOf(Card::class, $card);
        }

        $this->assertNull($deck->drawRandomCard());
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::drawCard
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawCard(Deck $deck)
    {
        $card = new Card(9, new Suit("Clubs"));
        $initialSize = $deck->getSize();
        $deck->addCard($card);

        $this->assertEquals(
            $initialSize + 1,
            $deck->getSize()
        );

        $this->assertTrue($deck->drawCard($card));
        $this->assertEquals(
            $initialSize,
            $deck->getSize()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::drawFromTop
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawFromTop(Deck $deck)
    {
        // Remove all cards from deck
        while ($deck->getSize() > 0) {
            $card = $deck->drawRandomCard();
            $this->assertInstanceOf(Card::class, $card);
        }

        $cards = array(
            0 => new Card(4, new Suit("Clubs")),
            1 => new Card(5, new Suit("Diamonds"))
        );

        $deck->addCards($cards);
        $this->assertEquals(2, $deck->getSize());

        $result = $deck->drawFromTop(1);
        $this->assertContains($cards[0], $result);
        $this->assertEquals(1, $deck->getSize());

        $deck->addCards($cards);
        $this->assertEquals(3, $deck->getSize());

        $result = $deck->drawFromTop(2);
        $this->assertContains($cards[0], $result);
        $this->assertContains($cards[1], $result);
        $this->assertEquals(1, $deck->getSize());

        $this->assertEmpty($deck->drawFromTop(2));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::drawCard
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawCardWithEmptyDeck(Deck $deck)
    {
        // Remove all cards from deck
        while ($deck->getSize() > 0) {
            $card = $deck->drawRandomCard();
            $this->assertInstanceOf(Card::class, $card);
        }

        $card = new Card(9, new Suit("Clubs"));
        $this->assertFalse($deck->drawCard($card));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::drawCard
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawCardNotInDeck(Deck $deck)
    {
        // Remove all cards from deck
        while ($deck->getSize() > 0) {
            $card = $deck->drawRandomCard();
            $this->assertInstanceOf(Card::class, $card);
        }

        $card1 = new Card(2, new Suit("Clubs"));
        $deck->addCard($card1);
        $card2 = new Card(7, new Suit("Clubs"));
        $this->assertFalse($deck->drawCard($card2));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::drawCardAt
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawCardAt(Deck $deck)
    {
        $deck->addCard(new Card(5, new Suit('Hearts')));
        $initialSize = $deck->getSize();

        $this->assertInstanceOf(
            Card::class,
            $this->invokeMethod($deck, "drawCardAt", array(0))
        );
        $this->assertEquals(
            $initialSize - 1,
            $deck->getSize()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\Deck::drawCardAt
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawCardAtInvalidIndex(Deck $deck)
    {
        $this->assertNull(
            $this->invokeMethod(
                $deck,
                "drawCardAt",
                array($deck->getSize() + 1)
            )
        );
    }
}
