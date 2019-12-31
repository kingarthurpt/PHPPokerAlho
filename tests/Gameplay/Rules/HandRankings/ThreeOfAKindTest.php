<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\ThreeOfAKind;

class ThreeOfAKindTest extends \Tests\BaseTestCase
{
    public function testHasRanking()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('3s 3c 3h 5c 8h');

        $handRanking = new ThreeOfAKind();
        $this->assertTrue($handRanking->hasRanking($cards));
    }
}
