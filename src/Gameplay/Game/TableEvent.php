<?php

namespace PHPPokerAlho\Gameplay\Game;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class TableEvent
{
    /**
     * Fired when a Player joins the Table
     *
     * @var int
     */
    const PLAYER_JOINS = 1;

    /**
     * Fired when a Player leaves the Table
     *
     * @var int
     */
    const PLAYER_LEAVES = 2;

    /**
     * The Event's type
     *
     * @var int
     */
    protected $type;

    /**
     * The Event's message
     *
     * @var string
     */
    protected $message;

    // $action $actor $date $actionData

    /**
     * Constructor
     *
     * @since  {nextRelease}
     *
     * @param  int $event The event type
     * @param  string $message The event's message
     */
    public function __construct(int $event, string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the Event's type
     *
     * @since  {nextRelease}
     *
     * @return int The type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the Event's message
     *
     * @since  {nextRelease}
     *
     * @return string The message
     */
    public function getMessage()
    {
        return $this->message;
    }
}
