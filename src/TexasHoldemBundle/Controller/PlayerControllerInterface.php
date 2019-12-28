<?php

namespace TexasHoldemBundle\Controller;

use TexasHoldemBundle\Gameplay\Game\TableEvent;

interface PlayerControllerInterface
{
    /**
     * Handles the Player's behavior when receives a new TableEvent
     *
     * @param  TableEvent $event The event
     */
    public function handleEvent(TableEvent $event);
}
