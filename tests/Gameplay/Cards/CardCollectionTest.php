<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Cards\Card;
use PHPPokerAlho\Gameplay\Cards\StandardCard;
use PHPPokerAlho\Gameplay\Cards\Suit;
use PHPPokerAlho\Gameplay\Cards\CardCollection;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class CardCollectionTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::__construct
     *
     * @since  nextRelease
     *
     * @return CardCollection $collection The CardCollection
     */
    public function testConstructWithoutArgs()
    {
        $collection = new CardCollection(array());
        $this->assertEquals(
            array(),
            $this->getPropertyValue($collection, 'items')
        );

        return $collection;
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::__construct
     *
     * @since  nextRelease
     *
     * @return CardCollection $collection The CardCollection
     */
    public function testConstruct()
    {
        $suit = new Suit('Clubs', '♣');
        $cards = array(new Card(10, $suit), new Card(3, $suit));
        $collection = new CardCollection($cards);

        $this->assertEquals(
            $cards,
            $this->getPropertyValue($collection, 'items')
        );

        return $collection;
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::__toString
     *
     * @depends testConstructWithoutArgs
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testToStringWithEmptyCollection(CardCollection $collection)
    {
        $this->assertEquals('', $collection->__toString());
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::fromString
     *
     * @since  nextRelease
     */
    public function testFromString()
    {
        $this->assertNull(CardCollection::fromString("AcKc"));

        $this->assertInstanceOf(
            CardCollection::class,
            CardCollection::fromString("Ac Kc")
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::__toString
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testToString(CardCollection $collection)
    {
        $this->assertEquals('[10♣][3♣]', $collection->__toString());
    }

    /**
      * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::toCliOutput
      *
      * @depends testConstruct
      *
      * @since  nextRelease
      *
      * @param  CardCollection $collection
      */
    public function testToCliOutput(CardCollection $collection)
    {
        $this->assertEquals('[10♣][3♣]', $collection->toCliOutput());
        $collection->removeCards();

        $cards = array(
            new StandardCard(10, new Suit('Clubs', '♣')),
            new StandardCard(11, new Suit('Clubs', '♣'))
        );
        $collection->addCards($cards);
        $this->assertEquals(
            '<bg=white;fg=black>[T<bg=white;fg=black>♣</>]</>'
                . '<bg=white;fg=black>[J<bg=white;fg=black>♣</>]</>',
            $collection->toCliOutput()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::getCards
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testGetCards(CardCollection $collection)
    {
        $this->assertEquals(
            $this->getPropertyValue($collection, 'items'),
            $collection->getCards()
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::getCardAt
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testGetCardAt(CardCollection $collection)
    {
        $cards = $collection->getCards();

        $this->assertEquals(
            $cards[0],
            $collection->getCardAt(0)
        );

        $this->assertNull($collection->getCardAt(count($cards)));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::setCards
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testSetCards(CardCollection $collection)
    {
        $collection->removeCards();
        $cards = array(
            new StandardCard(10, new Suit('Clubs', '♣')),
            new StandardCard(11, new Suit('Clubs', '♣'))
        );

        $collection->setCards($cards);
        $this->assertEquals(
            $cards,
            $this->getPropertyValue($collection, 'items')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::setCards
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testSetCardsWithInvalidArray(CardCollection $collection)
    {
        $collection->removeCards();
        $cards = array(new Suit('Clubs', '♣'));
        $this->assertFalse($collection->setCards($cards));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::addCard
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testAddCard(CardCollection $collection)
    {
        $card = new StandardCard(12, new Suit('Clubs', '♣'));

        $collection->addCard($card);
        $this->assertContains(
            $card,
            $this->getPropertyValue($collection, 'items')
        );

        $this->assertNull($collection->addCard($card));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::mergeCards
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testMergeCards(CardCollection $collection)
    {
        $this->assertFalse($collection->mergeCards(new CardCollection()));

        $cards = array(
            new StandardCard(1, new Suit('Clubs', '♣')),
            new StandardCard(2, new Suit('Clubs', '♣'))
        );
        $cardCollection = new CardCollection($cards);
        $collection->mergeCards($cardCollection);

        $this->assertContains(
            $cards[0],
            $this->getPropertyValue($collection, 'items')
        );
        $this->assertContains(
            $cards[1],
            $this->getPropertyValue($collection, 'items')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::addCards
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testAddCards(CardCollection $collection)
    {
        $cards = array(
            new StandardCard(1, new Suit('Clubs', '♣')),
            new StandardCard(2, new Suit('Clubs', '♣'))
        );

        $collection->addCards($cards);
        $this->assertContains(
            $cards[0],
            $this->getPropertyValue($collection, 'items')
        );
        $this->assertContains(
            $cards[1],
            $this->getPropertyValue($collection, 'items')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\CardCollection::removeCards
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  CardCollection $collection
     */
    public function testRemoveCard(CardCollection $collection)
    {
        $size = $collection->getSize();

        $cards = $collection->removeCards();
        $this->assertEquals(
            array(),
            $this->getPropertyValue($collection, 'items')
        );
        $this->assertEquals($size, count($cards));
    }
}
