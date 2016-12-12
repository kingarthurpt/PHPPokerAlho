<?php

namespace PHPPokerAlho\Game;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class Table
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
    private $seats;

    /**
     * The Table's Dealer
     *
     * @var Dealer
     */
    private $dealer;

    /**
     * Array of Players seated at the Table
     *
     * @var array
     */
    private $players;

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

        $this->players = array();
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
        return $this;
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
}
