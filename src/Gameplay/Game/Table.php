<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Game\GameSubject;
use PHPPokerAlho\Gameplay\Cards\Card;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Table extends GameSubject
{
    /**
     * The Table's name
     *
     * @var string
     */
    private $name;

    /**
     * The Table's number of seats
     *
     * @var array
     */
    private $seats = 0;

    /**
     * The Table's Dealer
     *
     * @var Dealer
     */
    private $dealer = null;

    /**
     * Array of Players seated at the Table
     *
     * @var array
     */
    private $players = array();

    /**
     * Array of discarded Cards
     *
     * @var array
     */
    private $muck = array();

    /**
     * The flop Cards
     *
     * @var array
     */
    private $flop = array();

    /**
     * The turn Card
     *
     * @var Card
     */
    private $turn = null;

    /**
     * The river Card
     *
     * @var Card
     */
    private $river = null;

    /**
     * The main pot
     *
     * @var float
     */
    private $pot = 0;

    /**
     * Constructor
     *
     * @since  {nextRelease}
     *
     * @param  string $name The Table's name
     * @param  int $seats The Table's number of seats
     */
    public function __construct($name, $seats = null)
    {
        $this->setName($name);

        if (!is_null($seats)) {
            $this->setSeatsCount($seats);
        }
    }

    /**
     * Return a string representation of the Table
     *
     * @since  {nextRelease}
     *
     * @return string The Card represented as a string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get the Table's name
     *
     * @since  {nextRelease}
     *
     * @return string The Table's name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the Table's name
     *
     * @since  {nextRelease}
     *
     * @param  string $name The Table's name
     *
     * @return Table
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the Table's number of seats
     *
     * @since  {nextRelease}
     *
     * @return string The Table's number of seats
     */
    public function getSeatsCount()
    {
        return $this->seats;
    }

    /**
     * Set the Table's number of seats
     *
     * @since  {nextRelease}
     *
     * @param  int $value The Table's number of seats
     *
     * @return Table
     */
    public function setSeatsCount(int $value)
    {
        $this->seats = $value;
        return $this;
    }

    /**
     * Get the Table's Dealer
     *
     * @since  {nextRelease}
     *
     * @return Dealer The Table's Dealer
     */
    public function getDealer()
    {
        return $this->dealer;
    }

    /**
     * Set the Table's Dealer
     *
     * @since  {nextRelease}
     *
     * @param  Dealer $dealer The Table's Dealer
     *
     * @return Table
     */
    public function setDealer(Dealer $dealer)
    {
        $this->dealer = $dealer;
        return $this;
    }

    /**
     * Add a Player to the Table
     *
     * @since  {nextRelease}
     *
     * @param  Player $player A Player
     *
     * @return Table
     */
    public function addPlayer(Player $player)
    {
        // Table is full
        if ($this->getPlayerCount() == $this->seats) {
            return null;
        }

        // Player is already seated
        if (in_array($player, $this->players)) {
            return null;
        }

        $this->players[] = $player;

        // Notifies all GameObservers that a new Player has joined the Table
        $this->notify();

        return $this;
    }

    /**
     * Remove a Player from the Table
     *
     * @since  {nextRelease}
     *
     * @param  Player $player The Player to be removed from the Table
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function removePlayer(Player $player)
    {
        if ($this->getPlayerCount() == 0) {
            return false;
        }

        foreach ($this->players as $key => $value) {
            if ($value == $player) {
                unset($this->players[$key]);
                return true;
            }
        }

        return false;
    }

    /**
     * Get the Players seated at the Table
     *
     * @since  {nextRelease}
     *
     * @return array The seated Players
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Get the number of seated Players
     *
     * @since  {nextRelease}
     *
     * @return int The number of seated Players
     */
    public function getPlayerCount()
    {
        return count($this->players);
    }

    /**
     * Add a Card to the muck
     *
     * @since  {nextRelease}
     *
     * @param  Card $card A discarded Card
     *
     * @return Table|null Table on success, null on failure
     */
    public function muckCard(Card $card)
    {
        // Player is already seated
        if (in_array($card, $this->muck)) {
            return null;
        }

        $this->muck[] = $card;
        return $this;
    }

    /**
     * Remove and get all Cards from the muck
     *
     * @since  {nextRelease}
     *
     * @author Artur Alves <artur.alves@gatewit.com>
     *
     * @return array The discarded Cards
     */
    public function getMuck()
    {
        $cards = $this->muck;
        $this->muck = array();
        return $cards;
    }

    /**
     * Set the flop Cards
     *
     * @since  {nextRelease}
     *
     * @param  array $cards The flop Cards
     */
    public function setFlop(array $cards)
    {
        if (count($cards) != 3) {
            return false;
        }

        foreach ($cards as $card) {
            if (!$card instanceof Card) {
                return false;
            }
        }

        $this->flop = $cards;
        return true;
    }

    /**
     * Get the flop Cards
     *
     * @since  {nextRelease}
     *
     * @return array The flop Cards
     */
    public function getFlop()
    {
        return $this->flop;
    }

    /**
     * Set the turn Card
     *
     * @since  {nextRelease}
     *
     * @param  Card $card The turn Card
     */
    public function setTurn(Card $card)
    {
        $this->turn = $card;
    }

    /**
     * Get the turn Card
     *
     * @since  {nextRelease}
     *
     * @return array The turn Card
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * Set the river Card
     *
     * @since  {nextRelease}
     *
     * @param  Card $card The river Card
     */
    public function setRiver(Card $card)
    {
        $this->river = $card;
    }

    /**
     * Get the river Card
     *
     * @since  {nextRelease}
     *
     * @return array The river Card
     */
    public function getRiver()
    {
        return $this->river;
    }
}
