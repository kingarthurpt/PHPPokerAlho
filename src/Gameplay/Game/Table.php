<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Game\TableSubject;
use PHPPokerAlho\Gameplay\Cards\Card;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Table extends TableSubject
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
     * The community Cards
     *
     * @var CommunityCards
     */
    private $communityCards = null;

    /**
     * Array of discarded Cards
     *
     * @var Muck
     */
    private $muck = null;

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

        $this->communityCards = new CommunityCards();
        $this->muck = new Muck();
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

        // Notifies all TableObservers that a new Player has joined the Table
        $this->notify(new TableEvent(
            TableEvent::PLAYER_JOINS,
            $player->getName() . " has joined the table."
        ));

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

                $this->notify(new TableEvent(
                    TableEvent::PLAYER_LEAVES,
                    $player->getName() . " has left the table."
                ));

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
     * Get the Table's CommunityCards
     *
     * @since  {nextRelease}
     *
     * @return CommunityCards The Table's CommunityCards
     */
    public function getCommunityCards()
    {
        return $this->communityCards;
    }

    /**
     * Set the Table's CommunityCards
     *
     * @since  {nextRelease}
     *
     * @param  CommunityCards $cards The Table's CommunityCards
     *
     * @return Table
     */
    public function setCommunityCards(CommunityCards $cards)
    {
        $this->communityCards = $cards;
        return $this;
    }

    /**
     * Get the Table's Muck
     *
     * @since  {nextRelease}
     *
     * @return CommunityCards The Table's Muck
     */
    public function getMuck()
    {
        return $this->muck;
    }

    /**
     * Set the Table's Muck
     *
     * @since  {nextRelease}
     *
     * @param  Muck $cards The Table's Muck
     *
     * @return Table
     */
    public function setMuck(Muck $cards)
    {
        $this->muck = $cards;
        return $this;
    }
}
