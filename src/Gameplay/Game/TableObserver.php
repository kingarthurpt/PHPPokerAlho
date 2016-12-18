<?php


namespace PHPPokerAlho\Gameplay\Game;

/**
 * A TableObserver which is updated with TableEvents that happen on TableSubject
 *
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
abstract class TableObserver
{
    /**
     * Get a notification about changes in the TableSubject
     *
     * @since  {nextRelease}
     *
     * @param  TableSubject $subject
     * @param  TableEvent $event The Event being fired
     */
    abstract public function update(TableSubject $subject, TableEvent $event);
}
