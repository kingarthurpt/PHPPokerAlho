<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\HighCard;

class HighCardTest extends \Tests\BaseTestCase
{
    public function testHasRanking()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('2s 3s 4c 8c 9h');

        $handRanking = new HighCard();
        $this->assertTrue($handRanking->hasRanking($cards));
    }
}
