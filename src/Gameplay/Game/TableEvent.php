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
     * Fired when a Player adds chips to the Table
     *
     * @var int
     */
    const PLAYER_ADD_CHIPS = 3;

    /**
     * Fired when a Player pays the small blind
     *
     * @var int
     */
    const PLAYER_PAID_SMALL_BLIND = 4;

    /**
     * Fired when a Player pays the big blind
     *
     * @var int
     */
    const PLAYER_PAID_BIG_BLIND = 5;

    /**
     * Fired when a Player receives his hand
     *
     * @var int
     */
    const PLAYER_RECEIVED_CARDS = 6;

    /**
     * Fired when a Player needs to take action
     *
     * @var int
     */
    const PLAYER_ACTION_NEEDED = 7;

    /**
     * Fired when a Player folds his hand
     *
     * @var int
     */
    const PLAYER_ACTION_FOLD = 8;

    /**
     * Fired when a Player checks
     *
     * @var int
     */
    const PLAYER_ACTION_CHECK = 9;

    /**
     * Fired when a Player calls
     *
     * @var int
     */
    const PLAYER_ACTION_CALL = 10;

    /**
     * Fired when a Player raises
     *
     * @var int
     */
    const PLAYER_ACTION_RAISE = 11;

    /**
     * Fired when a Player goes all-in
     *
     * @var int
     */
    const PLAYER_ACTION_ALLIN = 12;

    /**
     * Fired when a Player shows his hand
     *
     * @var int
     */
    const PLAYER_ACTION_SHOW_HAND = 13;

    /**
     * Fired when a Player mucks his hand
     *
     * @var int
     */
    const PLAYER_ACTION_MUCK_HAND = 14;

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
    public function __construct(int $event, string $message = "")
    {
        $this->type = $event;
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
