<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\RoyalFlush;

class RoyalFlushTest extends \Tests\BaseTestCase
{
    private $rank;
    private $handStr;

    protected function setUp(): void
    {
        $this->rank = new RoyalFlush();
        $this->handStr = 'Ah Kh Th Jh Qh';
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
            [14, 13, 12, 11, 10],
            $this->rank->getValue($cards)
        );
    }

    public function testGetKickers()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString($this->handStr);

        $this->assertEquals(
            [],
            $this->rank->getKickers($cards, [14, 13, 12, 11, 10])
        );
    }
}
