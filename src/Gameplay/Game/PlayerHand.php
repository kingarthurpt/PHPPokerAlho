<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Cards\CardCollection;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class PlayerHand extends CardCollection
{
    protected $strength = null;

    public function setStrength(HandStrength $handStrength)
    {
        $this->strength = $handStrength;
    }
}
