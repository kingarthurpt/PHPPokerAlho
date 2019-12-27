<?php

namespace TexasHoldemBundle\Gameplay\Game;

/**
 * A chip stack.
 */
class Stack
{
    protected $size;

    public function __construct(float $size)
    {
        $this->size = $size;
    }

    /**
     * Get the Stack's size.
     *
     * @return string The Stack's size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Add chips to the Stack.
     *
     * @param float $value [description]
     */
    public function add(float $value)
    {
        $this->size += $value;
    }

    /**
     * Subtract chips from the Stack.
     *
     * @param float $value [description]
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function sub(float $value)
    {
        if ($this->size - $value < 0) {
            $this->size = 0;

            return false;
        }
        $this->size -= $value;

        return true;
    }
}
