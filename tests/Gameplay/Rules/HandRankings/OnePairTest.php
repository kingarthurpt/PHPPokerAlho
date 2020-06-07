<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\OnePair;

class OnePairTest extends \Tests\BaseTestCase
{
    private $rank;
    private $handStr;

    protected function setUp(): void
    {
        $this->rank = new OnePair();
        $this->handStr = '2s 3s 4c 8c 8h';
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
            [8],
            $this->rank->getValue($cards)
        );
    }

    public function testGetKickers()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString($this->handStr);

        $this->assertEquals(
            [4, 3, 2],
            $this->rank->getKickers($cards, [8])
        );
    }
}
