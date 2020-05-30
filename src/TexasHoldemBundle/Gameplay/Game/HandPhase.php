<?php

namespace TexasHoldemBundle\Gameplay\Game;

/**
 * A Poker hand.
 */
class HandPhase
{
    const PHASE_PRE_FLOP = 1;
    const PHASE_FLOP = 2;
    const PHASE_TURN = 3;
    const PHASE_RIVER = 4;
    const PHASE_SHOWDOWN = 5;

    protected $phase;

    public function __construct()
    {
        $this->id = time(); // temp
        $this->datetime = new \DateTime();
    }

    public function setPhase(HandPhase $phase): Hand
    {
        $this->phase = $phase;

        return $this;
    }

    public function getPhase(): int
    {
        return $this->phase;
    }
}
