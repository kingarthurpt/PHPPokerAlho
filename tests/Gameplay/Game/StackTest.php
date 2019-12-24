<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\Stack;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StackTest extends \Tests\BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Stack::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $stack = new Stack(99.9);
        $this->assertEquals(99.9, $this->getPropertyValue($stack, 'size'));

        return $stack;
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Stack::getSize
     *
     * @since  nextRelease
     */
    public function testGetSize()
    {
        $stack = new Stack(99.9);
        $this->assertEquals(99.9, $stack->getSize());
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Stack::add
     *
     * @since  nextRelease
     */
    public function testAdd()
    {
        $stack = new Stack(99.9);
        $stack->add(100.1);
        $this->assertEquals(200, $this->getPropertyValue($stack, 'size'));
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\Stack::sub
     *
     * @since  nextRelease
     */
    public function testSub()
    {
        $stack = new Stack(99.9);
        $this->assertTrue($stack->sub(9.9));
        $this->assertEquals(90, $this->getPropertyValue($stack, 'size'));

        $this->assertFalse($stack->sub(100));
        $this->assertEquals(0, $this->getPropertyValue($stack, 'size'));
    }
}
