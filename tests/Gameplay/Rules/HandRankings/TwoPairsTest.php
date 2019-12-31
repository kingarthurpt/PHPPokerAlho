<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\TwoPairs;

class TwoPairsTest extends \Tests\BaseTestCase
{
    public function testHasRanking()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('3s 3c 4c 8c 8h');

        $handRanking = new TwoPairs();
        $this->assertTrue($handRanking->hasRanking($cards));
    }
}
