<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\Event\TableEvent;

/**
 * A TableObserver which is updated with TableEvents that happen on TableSubject.
 */
abstract class TableObserver
{
    /**
     * Get a notification about changes in the TableSubject.
     *
     * @param TableSubject $subject
     * @param TableEvent   $event   The Event being fired
     */
    abstract public function update(TableSubject $subject, TableEvent $event);
}
