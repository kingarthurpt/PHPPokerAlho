<?php


namespace PHPPokerAlho\Gameplay\Game;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
abstract class GameObserver
{
    /**
     * Get a notification about changes in the GameSubject
     *
     * @since  {nextRelease}
     *
     * @param  GameSubject $subject
     */
    abstract public function update(GameSubject $subject);
}
