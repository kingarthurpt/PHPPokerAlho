<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\Flush;

class FlushTest extends \Tests\BaseTestCase
{
    public function testHasRanking()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('3s Qs 5c 9h 6s 5s Ks');

        $handRanking = new Flush();
        $this->assertTrue($handRanking->hasRanking($cards));
    }
}
