<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\RoyalFlush;

class RoyalFlushTest extends \Tests\BaseTestCase
{
    public function testHasRanking()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('Ah Kh Th Jh Qh');

        $handRanking = new RoyalFlush();
        $this->assertTrue($handRanking->hasRanking($cards));
    }
}
