<?php

namespace TexasHoldemBundle\Exception;

use TexasHoldemBundle\Gameplay\Game\Player;

class PlayerHandIsEmptyException extends \Exception
{
    public function __construct(Player $player)
    {
        parent::__construct(
            sprintf('The hand of player %s is empty', $player->getName())
        );
    }
}
