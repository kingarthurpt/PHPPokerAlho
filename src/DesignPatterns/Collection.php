<?php

namespace PHPPokerAlho\DesignPatterns;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
abstract class Collection
{
    /**
     * An array of collectable items
     *
     * @var array
     */
    protected $items = array();

    /**
     * Constructor
     *
     * @since  {nextRelease}
     *
     * @param  array $items The items
     */
    public function __construct(array $items = array())
    {
        if (!empty($items)) {
            $this->setItems($items);
        }
    }

    /**
     * Get the array of items
     *
     * @since  {nextRelease}
     *
     * @return array The array of items
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Get the item at a given key
     *
     * @since  {nextRelease}
     *
     * @param  int $key The item's key
     *
     * @return mixed The item at the given index
     */
    public function getItemAt(int $key)
    {
        return isset($this->items[$key]) ? $this->items[$key] : null;
    }

    /**
     * Set the array of items
     *
     * @since  {nextRelease}
     *
     * @param  array $items The array of items
     *
     * @return Collection The Collection
     */
    public function setItems(array $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Add an item to the Collection
     *
     * @since  {nextRelease}
     *
     * @param  mixed $item The item to be added to the Collection
     */
    public function addItem($item)
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Add an array of items to the Collection
     *
     * @since  {nextRelease}
     *
     * @param  Collection $items The array of items to add
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function addItems(array $items)
    {
        if (empty($items)) {
            return false;
        }

        $this->items = array_merge($this->items, $items);
        return true;
    }

    /**
     * Merge a Collection into this Collection
     *
     * @since  {nextRelease}
     *
     * @param  Collection $items The Collection to add
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function merge(Collection $collection)
    {
        if ($collection->getSize() < 1) {
            return false;
        }

        foreach ($collection->getItems() as $item) {
            $this->addItem($item);
        }

        return true;
    }

    /**
     * Get the Collection's size
     *
     * @since  {nextRelease}
     *
     * @return int The Collection's size
     */
    public function getSize()
    {
        return count($this->items);
    }

    /**
     * Remove and get an item with a given key
     *
     * @since  {nextRelease}
     *
     * @return mixed The item or null if not found
     */
    public function removeItemAt(int $key)
    {
        if (isset($this->items[$key])) {
            $item = $this->items[$key];
            unset($this->items[$key]);
            return $item;
        }
        return null;
    }

    /**
     * Remove and get all items in the collection
     *
     * @since  {nextRelease}
     *
     * @return array The array of items
     */
    public function removeItems()
    {
        $items = $this->items;
        $this->items = array();
        return $items;
    }
}
