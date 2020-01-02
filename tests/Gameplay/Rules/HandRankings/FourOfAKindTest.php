<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\FourOfAKind;

class FourOfAKindTest extends \Tests\BaseTestCase
{
    private $rank;
    private $handStr;

    protected function setUp(): void
    {
        $this->rank = new FourOfAKind();
        $this->handStr = 'Kh 3s 3h 3c 3d 6s 5s';
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
            [3],
            $this->rank->getValue($cards)
        );
    }

    public function testGetKickers()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString($this->handStr);

        $this->assertEquals(
            [13],
            $this->rank->getKickers($cards, [3])
        );
    }
}
