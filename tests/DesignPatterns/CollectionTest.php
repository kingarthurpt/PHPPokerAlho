<?php

namespace Tests\DesignPatterns;

use TexasHoldemBundle\DesignPatterns\Collection;
use TexasHoldemBundle\Gameplay\Cards\Suit;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class CollectionTest extends \Tests\BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::__construct
     *
     * @since  nextRelease
     */
    public function testConstructWithoutArgs()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $this->assertInstanceOf(Collection::class, $collection);

        $this->assertEquals(
            array(),
            $this->getPropertyValue($collection, 'items')
        );
    }

    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $items = array(new Suit('Clubs'), new Suit('Diamons'));
        $collection = $this->getMockForAbstractClass(
            Collection::class,
            array($items)
        );
        $this->assertInstanceOf(Collection::class, $collection);

        $this->assertEquals(
            $items,
            $this->getPropertyValue($collection, 'items')
        );
    }

    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::getItems
     *
     * @since  nextRelease
     */
    public function testGetItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);

        $this->assertEquals(
            $this->getPropertyValue($collection, 'items'),
            $collection->getItems()
        );
    }

    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::getItemAt
     *
     * @since  nextRelease
     */
    public function testGetItemAt()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $items = array(new Suit('Clubs'), new Suit('Diamons'));
        $collection->addItems($items);

        $this->assertEquals(
            $items[0],
            $collection->getItemAt(0)
        );

        $this->assertNull($collection->getItemAt(count($items)));
    }

    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::setItems
     *
     * @since  nextRelease
     */
    public function testSetItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $collection->removeItems();
        $items = array(
             new Suit('Clubs'),
             new Suit('Hearts')
        );

        $collection->setItems($items);
        $this->assertEquals(
            $items,
            $this->getPropertyValue($collection, 'items')
        );
    }

    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::addItem
     *
     * @since  nextRelease
     */
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

    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::merge
     *
     * @since  nextRelease
     */
    public function testMergeItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $newCollection = $this->getMockForAbstractClass(Collection::class);
        $this->assertFalse($collection->merge($newCollection));

        $items = array(new Suit('Clubs'), new Suit('Hearts'));
        $suitCollection = $this->getMockForAbstractClass(
            Collection::class,
            array($items)
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

    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::addItems
     *
     * @since  nextRelease
     */
    public function testAddItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $this->assertFalse($collection->addItems(array()));

        $items = array(
            new Suit('Clubs'),
            new Suit('Clubs')
        );

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

    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::removeItemAt
     *
     * @since  nextRelease
     */
    public function testRemoveItemAt()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $items = array(
            new Suit('Clubs'),
            new Suit('Hearts')
        );

        $collection->addItems($items);
        $size = $collection->getSize();

        $item = $collection->removeItemAt(0);
        $this->assertEquals(
            $items[0],
            $item
        );
        $this->assertEquals(
            $size - 1,
            $collection->getSize()
        );

        $this->assertNull($collection->removeItemAt($collection->getSize() + 1));
    }

    /**
     * @covers \TexasHoldemBundle\DesignPatterns\Collection::removeItems
     *
     * @since  nextRelease
     */
    public function testRemoveItems()
    {
        $collection = $this->getMockForAbstractClass(Collection::class);
        $size = $collection->getSize();

        $items = $collection->removeItems();
        $this->assertEquals(
            array(),
            $this->getPropertyValue($collection, 'items')
        );
        $this->assertEquals($size, count($items));
    }
}
