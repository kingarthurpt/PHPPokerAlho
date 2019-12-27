<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\Stack;

class StackTest extends \Tests\BaseTestCase
{
    public function testConstruct()
    {
        $stack = new Stack(99.9);
        $this->assertEquals(99.9, $this->getPropertyValue($stack, 'size'));

        return $stack;
    }

    public function testGetSize()
    {
        $stack = new Stack(99.9);
        $this->assertEquals(99.9, $stack->getSize());
    }

    public function testAdd()
    {
        $stack = new Stack(99.9);
        $stack->add(100.1);
        $this->assertEquals(200, $this->getPropertyValue($stack, 'size'));
    }

    public function testSub()
    {
        $stack = new Stack(99.9);
        $this->assertTrue($stack->sub(9.9));
        $this->assertEquals(90, $this->getPropertyValue($stack, 'size'));

        $this->assertFalse($stack->sub(100));
        $this->assertEquals(0, $this->getPropertyValue($stack, 'size'));
    }
}
