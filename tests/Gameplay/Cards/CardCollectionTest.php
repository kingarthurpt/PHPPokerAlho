<?php

namespace Tests\Gameplay\Cards;

use TexasHoldemBundle\Gameplay\Cards\Card;
use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Cards\StandardCard;
use TexasHoldemBundle\Gameplay\Cards\Suit;

class CardCollectionTest extends \Tests\BaseTestCase
{
    private $cards;
    private $collection;

    protected function setUp(): void
    {
        $suit = new Suit('Clubs', '♣');
        $this->cards = [new Card(10, $suit), new Card(3, $suit)];
        $this->collection = new CardCollection($this->cards);
    }

    public function testConstructWithoutArgs()
    {
        $collection = new CardCollection();
        $this->assertEquals(
            [],
            $this->getPropertyValue($collection, 'items')
        );
    }

    public function testConstruct()
    {
        $this->assertEquals(
            $this->cards,
            $this->getPropertyValue($this->collection, 'items')
        );
    }

    public function testToStringWithEmptyCollection()
    {
        $collection = new CardCollection();
        $this->assertEquals('', $collection->__toString());
    }

    public function testToString()
    {
        $this->assertEquals('[10♣][3♣]', $this->collection->__toString());
    }

    public function testToCliOutput()
    {
        $this->assertEquals('[10♣][3♣]', $this->collection->toCliOutput());
        $this->collection->removeCards();

        $cards = [
            new StandardCard(10, new Suit('Clubs', '♣')),
            new StandardCard(11, new Suit('Clubs', '♣')),
        ];
        $this->collection->addCards($cards);
        $this->assertEquals(
            '<bg=white;fg=black>[T<bg=white;fg=black>♣</>]</>'
                .'<bg=white;fg=black>[J<bg=white;fg=black>♣</>]</>',
            $this->collection->toCliOutput()
        );
    }

    public function testGetCards()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->collection, 'items'),
            $this->collection->getCards()
        );
    }

    public function testGetCardAt()
    {
        $cards = $this->collection->getCards();

        $this->assertEquals(
            $cards[0],
            $this->collection->getCardAt(0)
        );

        $this->assertNull($this->collection->getCardAt(count($cards)));
    }

    public function testSetCards()
    {
        $this->collection->removeCards();
        $cards = [
            new StandardCard(10, new Suit('Clubs', '♣')),
            new StandardCard(11, new Suit('Clubs', '♣')),
        ];

        $this->collection->setCards($cards);
        $this->assertEquals(
            $cards,
            $this->getPropertyValue($this->collection, 'items')
        );
    }

    public function testSetCardsWithInvalidArray()
    {
        $this->collection->removeCards();
        $cards = [new Suit('Clubs', '♣')];
        $this->assertFalse($this->collection->setCards($cards));
    }

    public function testAddCard()
    {
        $card = new StandardCard(12, new Suit('Clubs', '♣'));

        $this->collection->addCard($card);
        $this->assertContains(
            $card,
            $this->getPropertyValue($this->collection, 'items')
        );

        $this->assertNull($this->collection->addCard($card));
    }

    public function testMergeCards()
    {
        $this->assertFalse($this->collection->mergeCards(new CardCollection()));

        $cards = [
            new StandardCard(1, new Suit('Clubs', '♣')),
            new StandardCard(2, new Suit('Clubs', '♣')),
        ];
        $cardCollection = new CardCollection($cards);
        $this->collection->mergeCards($cardCollection);

        $this->assertContains(
            $cards[0],
            $this->getPropertyValue($this->collection, 'items')
        );
        $this->assertContains(
            $cards[1],
            $this->getPropertyValue($this->collection, 'items')
        );
    }

    public function testAddCards()
    {
        $cards = [];
        $this->assertFalse($this->collection->addCards($cards));

        $cards = [
            new StandardCard(1, new Suit('Clubs', '♣')),
            new StandardCard(2, new Suit('Clubs', '♣')),
            'invalidCard',
        ];

        $this->collection->addCards($cards);
        $this->assertContains(
            $cards[0],
            $this->getPropertyValue($this->collection, 'items')
        );
        $this->assertContains(
            $cards[1],
            $this->getPropertyValue($this->collection, 'items')
        );
    }

    public function testRemoveCard()
    {
        $size = $this->collection->getSize();

        $cards = $this->collection->removeCards();
        $this->assertEquals(
            [],
            $this->getPropertyValue($this->collection, 'items')
        );
        $this->assertEquals($size, count($cards));
    }
}
