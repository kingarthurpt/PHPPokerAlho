<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\StraightFlush;

class StraightFlushTest extends StraightTest
{
    protected function setUp(): void
    {
        $this->rank = new StraightFlush();
        $this->handStr = '4s 5s 6s 7s 8s';
        $this->rankCards = [8, 7, 6, 5, 4];
    }
}
