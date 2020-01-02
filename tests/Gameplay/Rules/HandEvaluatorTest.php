<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Rules\HandEvaluator;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Game\HandStrength;
use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;

class HandEvaluatorTest extends \Tests\BaseTestCase
{
    private $evaluator;

    protected function setUp(): void
    {
        $this->evaluator = new HandEvaluator();
    }

    public function testGetName()
    {
        $expected = [];
        $hands = [];
        $this->assertEquals($expected, $this->evaluator->compareHands($hands));
    }

    public function testGetStrength()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('2s 3s 4c 2c');
        $this->assertNull($this->evaluator->getStrength($cards));

        $cards = $factory->makeFromString('2s 3s 4c 2c 5h Ac Kc Qh');
        $this->assertNull($this->evaluator->getStrength($cards));

        $cards = $factory->makeFromString('2s 3s 4c 2c 6h Ac Kc');
        $expected = new HandStrength(2, [2], [14, 13, 6]);

        $this->assertEquals(
            $expected,
            $this->evaluator->getStrength($cards)
        );
    }
}
