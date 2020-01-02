<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\Straight;

class StraightTest
{
    protected $rank;
    protected $handStr;
    protected $rankCards;

    protected function setUp(): void
    {
        $this->rank = new Straight();
        $this->handStr = '3s 4c 6h 5c 7h';
        $this->rankCards = [7, 6, 5, 4, 3];
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
            $this->rankCards,
            $this->rank->getValue($cards)
        );
    }

    public function testGetKickers()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString($this->handStr);

        $this->assertEquals(
            [],
            $this->rank->getKickers($cards, $this->rankCards)
        );
    }
}
