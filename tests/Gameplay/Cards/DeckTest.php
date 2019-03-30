<?php

namespace Tests;

use TexasHoldemBundle\Gameplay\Cards\Deck;
use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\Suit;

class DeckTest extends BaseTestCase
{
    private $deck;

    public function setUp()
    {
        $this->deck = new Deck();
    }

    public function testShuffle()
    {
        $this->deck->addCard(new Card(10, new Suit('Spades')));
        $this->deck->addCard(new Card(5, new Suit('Hearts')));

        // Performs a deep copy of $deck into $deckBeforeShuffling
        $deckBeforeShuffling = [];
        foreach ($this->deck as $key => $value) {
            $deckBeforeShuffling[$key] = clone $value;
        }

        $this->assertTrue($this->deck->shuffle());

        $this->assertNotEquals(
            $deckBeforeShuffling,
            $this->deck
        );
    }

    public function testDrawRandomCard()
    {
        $this->deck->addCard(new Card(5, new Suit('Hearts')));
        $initialSize = $this->deck->getSize();

        $card = $this->deck->drawRandomCard();
        $this->assertInstanceOf(Card::class, $card);

        $this->assertEquals(
            $initialSize - 1,
            $this->deck->getSize()
        );
    }

    public function testDrawRandomCardWithEmptyDeck()
    {
        // Remove all cards from deck
        while ($this->deck->getSize() > 0) {
            $card = $this->deck->drawRandomCard();
            $this->assertInstanceOf(Card::class, $card);
        }

        $this->assertNull($this->deck->drawRandomCard());
    }

    public function testDrawCard()
    {
        $card = new Card(9, new Suit("Clubs"));
        $initialSize = $this->deck->getSize();
        $this->deck->addCard($card);

        $this->assertEquals(
            $initialSize + 1,
            $this->deck->getSize()
        );

        $this->assertTrue($this->deck->drawCard($card));
        $this->assertEquals(
            $initialSize,
            $this->deck->getSize()
        );
    }

    public function testDrawFromTop()
    {
        // Remove all cards from deck
        while ($this->deck->getSize() > 0) {
            $card = $this->deck->drawRandomCard();
            $this->assertInstanceOf(Card::class, $card);
        }

        $cards = [
            0 => new Card(4, new Suit("Clubs")),
            1 => new Card(5, new Suit("Diamonds"))
        ];

        $this->deck->addCards($cards);
        $this->assertEquals(2, $this->deck->getSize());

        $result = $this->deck->drawFromTop(1);
        $this->assertEquals($cards[0], $result);
        $this->assertEquals(1, $this->deck->getSize());

        $this->deck->addCards($cards);
        $this->assertEquals(3, $this->deck->getSize());

        $result = $this->deck->drawFromTop(2);
        $this->assertContains($cards[0], $result->getCards());
        $this->assertContains($cards[1], $result->getCards());
        $this->assertEquals(1, $this->deck->getSize());

        $this->assertEmpty($this->deck->drawFromTop(2));
    }

    public function testDrawCardWithEmptyDeck()
    {
        // Remove all cards from deck
        while ($this->deck->getSize() > 0) {
            $card = $this->deck->drawRandomCard();
            $this->assertInstanceOf(Card::class, $card);
        }

        $card = new Card(9, new Suit("Clubs"));
        $this->assertFalse($this->deck->drawCard($card));
    }

    public function testDrawCardNotInDeck()
    {
        // Remove all cards from deck
        while ($this->deck->getSize() > 0) {
            $card = $this->deck->drawRandomCard();
            $this->assertInstanceOf(Card::class, $card);
        }

        $card1 = new Card(2, new Suit("Clubs"));
        $this->deck->addCard($card1);
        $card2 = new Card(7, new Suit("Clubs"));
        $this->assertFalse($this->deck->drawCard($card2));
    }

    public function testDrawCardAt()
    {
        $this->deck->addCard(new Card(5, new Suit('Hearts')));
        $initialSize = $this->deck->getSize();

        $this->assertInstanceOf(
            Card::class,
            $this->invokeMethod($this->deck, "drawCardAt", [0])
        );
        $this->assertEquals(
            $initialSize - 1,
            $this->deck->getSize()
        );
    }

    public function testDrawCardAtInvalidIndex()
    {
        $this->assertNull(
            $this->invokeMethod(
                $this->deck,
                "drawCardAt",
                [$this->deck->getSize() + 1]
            )
        );
    }
}
