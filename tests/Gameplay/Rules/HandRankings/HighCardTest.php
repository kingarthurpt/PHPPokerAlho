<?php

namespace Tests\Gameplay\Rules\HandRankings;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Rules\HandRanking;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\HighCard;

class HighCardTest extends \Tests\BaseTestCase
{
    private $rank;
    private $handStr;

    protected function setUp(): void
    {
        $this->rank = new HighCard();
        $this->handStr = '2s 3s 4c 8c 9h';
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
            [9],
            $this->rank->getValue($cards)
        );
    }

    public function testGetKickers()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString($this->handStr);

        $this->assertEquals(
            [8, 4, 3, 2],
            $this->rank->getKickers($cards, [9])
        );
    }
}
