<?php

namespace Tests\Stringifier;

use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Stack;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Stringifier\TableStringifier;

class TableStringifierTest extends \Tests\BaseTestCase
{
    private $instance;

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function setUp(): void
    {
        $this->instance = TableStringifier::getInstance();
    }

    public function testStringify()
    {
        $player1 = new Player('Player1');
        $player1->setStack(new Stack(40));

        $player2 = new Player('Player2');
        $player2->setStack(new Stack(60));

        $table = new Table('Table1', 4);
        $table
            ->addPlayer($player1)
            ->addPlayer($player2);

        $expected = sprintf(
            'Seat 1: Player1 (40 in chips)%sSeat 2: Player2 (60 in chips)%s',
            PHP_EOL,
            PHP_EOL
        );

        $this->assertEquals(
            $expected,
            $this->instance->stringify($table)
        );
    }
}
