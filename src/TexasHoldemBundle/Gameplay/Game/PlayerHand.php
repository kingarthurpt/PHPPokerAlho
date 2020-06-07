<?php

namespace TexasHoldemBundle\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;

class PlayerHand extends CardCollection
{
    /**
     * The strength of the player's hand.
     *
     * @var HandStrength
     */
    protected $strength = null;

    public function setHandStrength(HandStrength $handStrength)
    {
        $this->strength = $handStrength;
    }

    public function getHandStrength(): HandStrength
    {
        return $this->strength;
    }
}
