<?php

namespace Tests;

use PHPPokerAlho\Cards\Deck;
use PHPPokerAlho\Cards\Card;
use PHPPokerAlho\Cards\Suit;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class DeckTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Cards\Deck::__construct
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
     * @covers \PHPPokerAlho\Cards\Deck::addCard
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
     * @covers \PHPPokerAlho\Cards\Deck::getSize
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
     * @covers \PHPPokerAlho\Cards\Deck::shuffle
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
     * @covers \PHPPokerAlho\Cards\Deck::drawRandomCard
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawRandomCard(Deck $deck)
    {
        $initialSize = $deck->getSize();

        $card = $deck->drawRandomCard();
        $this->assertInstanceOf(Card::class, $card);

        $this->assertEquals(
            $initialSize - 1,
            $deck->getSize()
        );
    }

    /**
     * @covers \PHPPokerAlho\Cards\Deck::drawRandomCard
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  Deck $deck The Deck
     */
    public function testDrawRandomCardWithEmptyDeck(Deck $deck)
    {
        while ($deck->getSize() > 0) {
            $card = $deck->drawRandomCard();
            $this->assertInstanceOf(Card::class, $card);
        }

        $this->assertNull($deck->drawRandomCard());
    }
}
