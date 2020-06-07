<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\CardCollectionFactory;
use TexasHoldemBundle\Gameplay\Cards\StandardCardFactory;
use TexasHoldemBundle\Gameplay\Game\CommunityCards;
use TexasHoldemBundle\Gameplay\Game\HandStrength;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Rules\HandEvaluator;

class HandEvaluatorTest extends \Tests\BaseTestCase
{
    private $evaluator;

    protected function setUp(): void
    {
        $this->evaluator = new HandEvaluator();
    }

    // public function testGetName()
    // {
    //     $expected = [];
    //     $hands = [];
    //     $this->assertEquals($expected, $this->evaluator->compareHands($hands));
    // }

    public function testGetPlayerStrength()
    {
        $player = new Player('Player1');
        $table = new Table('Table1', 1);

        $cardCollectFactory = new CardCollectionFactory();
        $playerCards = $cardCollectFactory->makeFromString('Ac Kc');
        $flop = $cardCollectFactory->makeFromString('2s 3s 4c');
        $cardFactory = new StandardCardFactory();
        $turn = $cardFactory->makeFromString('2c');
        $river = $cardFactory->makeFromString('6h');

        $player->setHand($playerCards);
        $communityCards = new CommunityCards();
        $communityCards->setFlop($flop);
        $communityCards->setTurn($turn);
        $communityCards->setRiver($river);
        $table->setCommunityCards($communityCards);

        $expected = new HandStrength(2, [2], [14, 13, 6]);

        $this->assertEquals(
            $expected,
            $this->evaluator->getPlayerStrength($player, $table)
        );
    }

    public function testGetStrength()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('2s 3s 4c 2c');
        $this->assertNull($this->evaluator->getHandStrength($cards));

        $cards = $factory->makeFromString('2s 3s 4c 2c 5h Ac Kc Qh');
        $this->assertNull($this->evaluator->getHandStrength($cards));

        $cards = $factory->makeFromString('2s 3s 4c 2c 6h Ac Kc');
        $expected = new HandStrength(2, [2], [14, 13, 6]);

        $this->assertEquals(
            $expected,
            $this->evaluator->getHandStrength($cards)
        );
    }

    public function testGetStartingHandStrength()
    {
        $factory = new CardCollectionFactory();
        $cards = $factory->makeFromString('2s');
        $this->assertNull($this->evaluator->getStartingHandStrength($cards));

        $cards = $factory->makeFromString('2s 3s 4c');
        $this->assertNull($this->evaluator->getStartingHandStrength($cards));

        $cards = $factory->makeFromString('2s 2c');
        $expected = new HandStrength(2, [2], []);

        $this->assertEquals(
            $expected,
            $this->evaluator->getStartingHandStrength($cards)
        );
    }
}
