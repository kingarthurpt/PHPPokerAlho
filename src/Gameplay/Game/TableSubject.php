<?php

namespace PHPPokerAlho\Gameplay\Game;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
abstract class TableSubject
{
    /**
     * Array of TableObservers
     *
     * @var array
     */
    protected $observers = array();

    /**
     * Registers a TableObserver
     *
     * @since  {nextRelease}
     *
     * @param  TableObserver $observer
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function attach(TableObserver $observer)
    {
        if (in_array($observer, $this->observers)) {
            return false;
        }

        $this->observers[] = $observer;
        return true;
    }

    /**
     * Unregisters a TableObserver
     *
     * @since  {nextRelease}
     *
     * @param  TableObserver $observer
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function detach(TableObserver $observer)
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
     * Notifies all TableObservers about changes in the TableSubject
     *
     * @since  {nextRelease}
     *
     * @param TableEvent $event The Event being fired
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function notify(TableEvent $event)
    {
        if (empty($this->observers)) {
            return false;
        }

        foreach ($this->observers as $observer) {
            $observer->update($this, $event);
        }

        return true;
    }
}
