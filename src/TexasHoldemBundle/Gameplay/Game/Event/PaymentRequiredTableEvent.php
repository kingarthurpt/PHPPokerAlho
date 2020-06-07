<?php

namespace TexasHoldemBundle\Gameplay\Game\Event;

class PaymentRequiredTableEvent extends TableEvent
{
    /**
     * @var float
     */
    protected $amount;

    /**
     * Constructor.
     *
     * @param int    $event   The event type
     * @param float  $amount  The amount required to be paid
     * @param string $message The event's message
     */
    public function __construct(int $event, float $amount, string $message = '')
    {
        parent::__construct($event, $message);
        $this->amount = $amount;
    }

    /**
     * Get the amount required to be paid by a player.
     *
     * @return float The amount
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
