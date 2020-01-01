<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\ThreeOfAKind;

class ThreeOfAKindTest extends \Tests\BaseTestCase
{
    private $rank;
    private $handStr;

    protected function setUp(): void
    {
        $this->rank = new ThreeOfAKind();
        $this->handStr = '3s 3c 3h 5c 8h';
    }

    public function testHasRanking()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString($this->handStr);

        $this->assertTrue($this->rank->hasRanking($cards));
    }

    public function testGetValue()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString($this->handStr);

        $this->assertEquals(
            [3],
            $this->rank->getValue($cards)
        );
    }

    public function testGetKickers()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString($this->handStr);

        $this->assertEquals(
            [8, 5],
            $this->rank->getKickers($cards, [3])
        );
    }
}
