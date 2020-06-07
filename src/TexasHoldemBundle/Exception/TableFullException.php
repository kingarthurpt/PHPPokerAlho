<?php

namespace TexasHoldemBundle\Exception;

use TexasHoldemBundle\Gameplay\Game\Table;

class TableFullException extends \Exception
{
    public function __construct(Table $table)
    {
        parent::__construct(
            sprintf('The table %s is full', $table->getName())
        );
    }
}
