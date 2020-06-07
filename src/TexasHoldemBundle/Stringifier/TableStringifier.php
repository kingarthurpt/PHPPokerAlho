<?php

namespace TexasHoldemBundle\Stringifier;

use TexasHoldemBundle\DesignPatterns\Singleton;
use TexasHoldemBundle\Gameplay\Game\Table;

class TableStringifier extends Singleton
{
    /**
     * Retuns a string representation of a Table.
     *
     * @return string
     */
    public function stringify(Table $table): string
    {
        $string = '';
        $players = $table->getPlayers();
        for ($i = 0; $i < count($players); ++$i) {
            $string .= sprintf(
                'Seat %s: %s (%s in chips)%s',
                $i + 1,
                $players[$i]->getName(),
                $players[$i]->getStack()->getSize(),
                PHP_EOL
            );
        }

        return $string;
    }
}
