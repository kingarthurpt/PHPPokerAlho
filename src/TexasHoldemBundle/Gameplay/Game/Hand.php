<?php

namespace TexasHoldemBundle\Gameplay\Game;

/**
 * A Poker hand
 *
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Hand
{
    protected $id;
    protected $datetime;
    protected $table;
    protected $players;
    protected $smallBlind;
    protected $bigBlind;

    public function __construct()
    {
        $this->id = time(); // temp
        $this->datetime = new \DateTime();
    }

    public function setTable(Table $table)
    {
        $this->table = $table;
        $table->setActiveHand($this);
        return $this;
    }

    public function setPlayers(array $players)
    {
        $this->players = $players;
        return $this;
    }

    public function setSmallBlind(float $amount)
    {
        $this->smallBlind = $amount;
        return $this;
    }

    public function setBigBlind(float $amount)
    {
        $this->bigBlind = $amount;
        return $this;
    }
}
