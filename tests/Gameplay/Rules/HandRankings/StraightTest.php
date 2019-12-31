<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\Straight;

class StraightTest extends \Tests\BaseTestCase
{
    public function testHasRanking()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('3s 4c 6h 5c 7h');

        $handRanking = new Straight();
        $this->assertTrue($handRanking->hasRanking($cards));
    }
}
