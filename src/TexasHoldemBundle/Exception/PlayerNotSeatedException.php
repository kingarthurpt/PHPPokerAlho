<?php

namespace TexasHoldemBundle\Exception;

use TexasHoldemBundle\Gameplay\Game\Player;

class PlayerNotSeatedException extends \Exception
{
    public function __construct(Player $player)
    {
        parent::__construct(
            sprintf('The player %s is not seated at a table yet', $player->getName())
        );
    }
}
