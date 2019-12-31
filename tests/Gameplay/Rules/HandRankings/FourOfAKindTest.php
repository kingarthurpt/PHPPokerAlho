<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\FourOfAKind;

class FourOfAKindTest extends \Tests\BaseTestCase
{
    public function testHasRanking()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('Kh 3s 3h 3c 3d 6s 5s');

        $handRanking = new FourOfAKind();
        $this->assertTrue($handRanking->hasRanking($cards));
    }
}
