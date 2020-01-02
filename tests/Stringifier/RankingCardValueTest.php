<?php

namespace Tests\Stringifier;

use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Stringifier\RankingCardValue;

class RankingCardValueTest extends \Tests\BaseTestCase
{
    private $instance;

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function setUp(): void
    {
        $this->instance = RankingCardValue::getInstance();
    }

    /**
     * @dataProvider getStringifyData
     *
     * @param mixed $cards
     * @param mixed $expected
     */
    public function testStringify($cards, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->instance->stringify($cards)
        );
    }

    public function getStringifyData()
    {
        return [
            'onePair' => [
                'rankingCards' => [4],
                'expected' => 'Four',
            ],
            'flush' => [
                'rankingCards' => [13],
                'expected' => 'King',
            ],
            'straight' => [
                'rankingCards' => [6, 5, 4, 3, 2],
                'expected' => 'Six, Five, Four, Three and Two',
            ],
        ];
    }
}
