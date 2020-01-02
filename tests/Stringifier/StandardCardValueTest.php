<?php

namespace Tests\Stringifier;

use TexasHoldemBundle\Stringifier\StandardCardValue;

class StandardCardValueTest extends \Tests\BaseTestCase
{
    private $instance;

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function setUp(): void
    {
        $this->instance = StandardCardValue::getInstance();
    }

    /**
     * @dataProvider getStringifyData
     *
     * @param mixed $ranking
     * @param mixed $expected
     */
    public function testStringify($ranking, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->instance->stringify($ranking)
        );
    }

    public function getStringifyData()
    {
        return [
            'three' => ['ranking' => 3, 'expected' => 'Three'],
            'jack' => ['ranking' => 11, 'expected' => 'Jack'],
            'queen' => ['ranking' => 12, 'expected' => 'Queen'],
            'king' => ['ranking' => 13, 'expected' => 'King'],
            'ace' => ['ranking' => 14, 'expected' => 'Ace'],
            'unknown' => ['ranking' => 1, 'expected' => 'Unknown'],
        ];
    }
}
