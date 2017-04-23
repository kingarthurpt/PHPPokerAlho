<?php

namespace PHPPokerAlho\Controller;

use PHPPokerAlho\Gameplay\Game\TableEvent;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
interface PlayerControllerInterface
{
    /**
     * Handles the Player's behavior when receives a new TableEvent
     *
     * @since  {nextRelease}
     *
     * @param  TableEvent $event The event
     */
    public function handleEvent(TableEvent $event);
}
