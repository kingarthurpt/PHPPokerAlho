<?php

namespace TexasHoldemBundle\Exception;

use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Table;

class PlayerAlreadySeatedException extends \Exception
{
    public function __construct(Player $player, Table $table)
    {
        parent::__construct(
            sprintf('The player %s is already seated at table %s', $player->getName(), $table->getName())
        );
    }
}
