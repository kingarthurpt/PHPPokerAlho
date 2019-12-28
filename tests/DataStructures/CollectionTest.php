<?php

namespace Tests\DataStructures;

use TexasHoldemBundle\DataStructures\Collection;
use TexasHoldemBundle\Gameplay\Cards\Suit;

class CollectionTest extends \Tests\BaseTestCase
{
    public function testConstructWithoutArgs()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $this->assertInstanceOf(Collection::class, $collection);

        $this->assertSame(
            [],
            $this->getPropertyValue($collection, 'items')
        );
    }

    public function testConstruct()
    {
        $items = [new Suit('Clubs'), new Suit('Diamons')];
        $collection = $this->getMockForAbstractClass(
            Collection::class,
            [$items]
        );
        $this->assertInstanceOf(Collection::class, $collection);

        $this->assertSame(
            $items,
            $this->getPropertyValue($collection, 'items')
        );
    }

    public function testGetItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);

        $this->assertSame(
            $this->getPropertyValue($collection, 'items'),
            $collection->getItems()
        );
    }

    public function testGetItemAt()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $items = [new Suit('Clubs'), new Suit('Diamons')];
        $collection->addItems($items);

        $this->assertSame(
            $items[0],
            $collection->getItemAt(0)
        );

        $this->assertNull($collection->getItemAt(count($items)));
    }

    public function testSetItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $collection->removeItems();
        $items = [
             new Suit('Clubs'),
             new Suit('Hearts'),
        ];

        $collection->setItems($items);
        $this->assertSame(
            $items,
            $this->getPropertyValue($collection, 'items')
        );
    }

    public function testAddItem()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $card = new Suit('Clubs');

        $collection->addItem($card);
        $this->assertContains(
            $card,
            $this->getPropertyValue($collection, 'items')
        );
    }

    public function testMergeItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $newCollection = $this->getMockForAbstractClass(Collection::class);
        $this->assertFalse($collection->merge($newCollection));

        $items = [new Suit('Clubs'), new Suit('Hearts')];
        $suitCollection = $this->getMockForAbstractClass(
            Collection::class,
            [$items]
        );
        $collection->merge($suitCollection);

        $this->assertContains(
            $items[0],
            $this->getPropertyValue($collection, 'items')
        );
        $this->assertContains(
            $items[1],
            $this->getPropertyValue($collection, 'items')
        );
    }

    public function testAddItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $this->assertFalse($collection->addItems([]));

        $items = [
            new Suit('Clubs'),
            new Suit('Clubs'),
        ];

        $collection->addItems($items);
        $this->assertContains(
            $items[0],
            $this->getPropertyValue($collection, 'items')
        );
        $this->assertContains(
            $items[1],
            $this->getPropertyValue($collection, 'items')
        );
    }

    public function testRemoveItemAt()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $items = [
            new Suit('Clubs'),
            new Suit('Hearts'),
        ];

        $collection->addItems($items);
        $size = $collection->getSize();

        $item = $collection->removeItemAt(0);
        $this->assertSame(
            $items[0],
            $item
        );
        $this->assertSame(
            $size - 1,
            $collection->getSize()
        );

        $this->assertNull($collection->removeItemAt($collection->getSize() + 1));
    }

    public function testRemoveItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $size = $collection->getSize();

        $items = $collection->removeItems();
        $this->assertSame(
            [],
            $this->getPropertyValue($collection, 'items')
        );
        $this->assertSame($size, count($items));
    }
}
