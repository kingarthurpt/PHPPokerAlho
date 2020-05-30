<?php

namespace TexasHoldemBundle\Gameplay\Game;

/**
 * A Poker hand.
 */
class Hand
{
    protected $id;
    protected $datetime;
    protected $table;
    protected $players;
    protected $smallBlind;
    protected $bigBlind;
    protected $phase;

    public function __construct()
    {
        $this->id = time(); // temp
        $this->datetime = new \DateTime();
        $this->phase = HandPhase::PHASE_PRE_FLOP;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setTable(Table $table)
    {
        $this->table = $table;
        $table->setActiveHand($this);

        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setPlayers(array $players)
    {
        $this->players = $players;

        return $this;
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function setSmallBlind(float $amount)
    {
        $this->smallBlind = $amount;

        return $this;
    }

    public function getSmallBlind()
    {
        return $this->smallBlind;
    }

    public function setBigBlind(float $amount)
    {
        $this->bigBlind = $amount;

        return $this;
    }

    public function getBigBlind()
    {
        return $this->bigBlind;
    }

    public function setPhase(int $phase): Hand
    {
        $this->phase = $phase;

        return $this;
    }

    public function getPhase(): int
    {
        return $this->phase;
    }
}
