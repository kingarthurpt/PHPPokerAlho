<?php

namespace Tests\Stringifier;

use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Stringifier\RankingCardValue;

class RankingCardValueTest extends \Tests\BaseTestCase
{
    private $instance;

    public function setUp(): void
    {
        $this->instance = RankingCardValue::getInstance();
    }

    /**
     * @dataProvider getStringifyData
     *
     * @param mixed $ranking
     * @param mixed $cards
     * @param mixed $expected
     */
    public function testStringify($ranking, $cards, $expected)
    {
        $this->assertEquals(
            $expected,
            $this->instance->stringify($ranking, $cards)
        );
    }

    public function getStringifyData()
    {
        return [
            'onePair' => [
                'ranking' => HandRanking::ONE_PAIR,
                'rankingCards' => [4],
                'expected' => 'Fours',
            ],
            'twoPairs' => [
                'ranking' => HandRanking::TWO_PAIR,
                'rankingCards' => [4, 8],
                'expected' => 'Fours and Eights',
            ],
            'threeOfAKind' => [
                'ranking' => HandRanking::THREE_OF_A_KIND,
                'rankingCards' => [9],
                'expected' => 'Nines',
            ],
            'threeOfAKind' => [
                'ranking' => HandRanking::THREE_OF_A_KIND,
                'rankingCards' => [9],
                'expected' => 'Nines',
            ],
            'flush' => [
                'ranking' => HandRanking::FLUSH,
                'rankingCards' => [13],
                'expected' => '',
            ],
            'straight' => [
                'ranking' => HandRanking::STRAIGHT,
                'rankingCards' => [6, 5, 4, 3, 2],
                'expected' => 'Six, Five, Four, Three and Two',
            ],
        ];
    }
}
