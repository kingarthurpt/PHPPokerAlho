<?php

namespace Tests;

use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\StandardCard;
use TexasHoldemBundle\Gameplay\Cards\Suit;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;

class CardCollectionTest extends BaseTestCase
{
    /**
     * @return CardCollection $collection The CardCollection
     */
    public function testConstructWithoutArgs()
    {
        $collection = new CardCollection([]);
        $this->assertEquals(
            [],
            $collection->getItems()
        );

        return $collection;
    }

    /**
     * @return CardCollection $collection The CardCollection
     */
    public function testConstruct()
    {
        $suit = new Suit('Clubs', '♣');
        $cards = [new Card(10, $suit), new Card(3, $suit)];
        $collection = new CardCollection($cards);

        $this->assertEquals(
            $cards,
            $collection->getItems()
        );

        return $collection;
    }

    /**
     * @depends testConstructWithoutArgs
     *
     * @param  CardCollection $collection
     */
    public function testToStringWithEmptyCollection(CardCollection $collection)
    {
        $this->assertEquals('', $collection->__toString());
    }

    /**
     * @depends testConstruct
     *
     * @param  CardCollection $collection
     */
    public function testToString(CardCollection $collection)
    {
        $this->assertEquals('[10♣][3♣]', $collection->__toString());
    }

    /**
      * @depends testConstruct
      *
      * @param  CardCollection $collection
      */
    public function testToCliOutput(CardCollection $collection)
    {
        $this->assertEquals('[10♣][3♣]', $collection->toCliOutput());
        $collection->removeCards();

        $cards = [
            new StandardCard(10, new Suit('Clubs', '♣')),
            new StandardCard(11, new Suit('Clubs', '♣'))
        ];
        $collection->addCards($cards);
        $this->assertEquals(
            '<bg=white;fg=black>[T<bg=white;fg=black>♣</>]</>'
                . '<bg=white;fg=black>[J<bg=white;fg=black>♣</>]</>',
            $collection->toCliOutput()
        );
    }

    /**
     * @depends testConstruct
     *
     * @param  CardCollection $collection
     */
    public function testGetCards(CardCollection $collection)
    {
        $this->assertEquals(
            $collection->getItems(),
            $collection->getCards()
        );
    }

    /**
     * @depends testConstruct
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
     * @depends testConstruct
     *
     * @param  CardCollection $collection
     */
    public function testSetCards(CardCollection $collection)
    {
        $collection->removeCards();
        $cards = [
            new StandardCard(10, new Suit('Clubs', '♣')),
            new StandardCard(11, new Suit('Clubs', '♣'))
        ];

        $collection->setCards($cards);
        $this->assertEquals(
            $cards,
            $collection->getItems()
        );
    }

    /**
     * @depends testConstruct
     *
     * @param  CardCollection $collection
     */
    public function testSetCardsWithInvalidArray(CardCollection $collection)
    {
        $collection->removeCards();
        $cards = [new Suit('Clubs', '♣')];
        $this->assertFalse($collection->setCards($cards));
    }

    /**
     * @depends testConstruct
     *
     * @param  CardCollection $collection
     */
    public function testAddCard(CardCollection $collection)
    {
        $card = new StandardCard(12, new Suit('Clubs', '♣'));

        $collection->addCard($card);
        $this->assertContains(
            $card,
            $collection->getItems()
        );

        $this->assertNull($collection->addCard($card));
    }

    /**
     * @depends testConstruct
     *
     * @param  CardCollection $collection
     */
    public function testMergeCards(CardCollection $collection)
    {
        $this->assertFalse($collection->mergeCards(new CardCollection()));

        $cards = [
            new StandardCard(1, new Suit('Clubs', '♣')),
            new StandardCard(2, new Suit('Clubs', '♣'))
        ];
        $cardCollection = new CardCollection($cards);
        $collection->mergeCards($cardCollection);

        $this->assertContains(
            $cards[0],
            $collection->getItems()
        );
        $this->assertContains(
            $cards[1],
            $collection->getItems()
        );
    }

    /**
     * @depends testConstruct
     *
     * @param  CardCollection $collection
     */
    public function testAddCards(CardCollection $collection)
    {
        $cards = [
            new StandardCard(1, new Suit('Clubs', '♣')),
            new StandardCard(2, new Suit('Clubs', '♣'))
        ];

        $collection->addCards($cards);
        $this->assertContains(
            $cards[0],
            $collection->getItems()
        );
        $this->assertContains(
            $cards[1],
            $collection->getItems()
        );
    }

    /**
     * @depends testConstruct
     *
     * @param  CardCollection $collection
     */
    public function testRemoveCard(CardCollection $collection)
    {
        $size = $collection->getSize();

        $cards = $collection->removeCards();
        $this->assertEquals(
            [],
            $collection->getItems()
        );
        $this->assertEquals($size, count($cards));
    }
}
