<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\RoyalFlush;

class RoyalFlushTest extends StraightTest
{
    protected function setUp(): void
    {
        $this->rank = new RoyalFlush();
        $this->handStr = 'Ah Kh Th Jh Qh';
        $this->rankCards = [14, 13, 12, 11, 10];
    }
}
