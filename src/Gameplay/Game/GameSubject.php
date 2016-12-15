<?php

namespace PHPPokerAlho\Gameplay\Game;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
abstract class GameSubject
{
    /**
     * Array of GameObservers
     *
     * @var array
     */
    protected $observers;

    /**
     * Constructor
     *
     * @since  {nextRelease}
     */
    public function __construct()
    {
        $this->observers = array();
    }

    /**
     * Registers a GameObserver
     *
     * @since  {nextRelease}
     *
     * @param  GameObserver $observer
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function attach(GameObserver $observer)
    {
        if (in_array($observer, $this->observers)) {
            return false;
        }

        $this->observers[] = $observer;
        return true;
    }

    /**
     * Unregisters a GameObserver
     *
     * @since  {nextRelease}
     *
     * @param  GameObserver $observer
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function detach(GameObserver $observer)
    {
        foreach ($this->observers as $key => $value) {
            if ($value == $observer) {
                unset($this->observers[$key]);
                return true;
            }
        }

        return false;
    }

    /**
     * Notifies all GameObservers about changes in the GameSubject
     *
     * @since  {nextRelease}
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function notify()
    {
        if (empty($this->observers)) {
            return false;
        }

        foreach ($this->observers as $observer) {
            $observer->update($this);
        }

        return true;
    }
}
