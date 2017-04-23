<?php

namespace PHPPokerAlho\Gameplay\Game;

use PHPPokerAlho\Gameplay\Game\TableSubject;

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
     * @var Stack
     */
    private $pot = 0;

    /**
     * The Table's Logger
     *
     * @var TableEventLogger
     */
    private $logger = null;

    /**
     * Array of Stacks.
     * Each Stack has the same key as the corresponding Player in $this->players
     *
     * @var array
     */
    private $playersBets = array();

    /**
     * The Hand which is currently being played at the Table
     *
     * @var Hand
     */
    private $activeHand = null;

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
     * Returns a string representation of the Table
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
     * Gets the Table's name
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
     * Sets the Table's name
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
     * Gets the Table's number of seats
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
     * Sets the Table's number of seats
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
     * Gets the Table's Dealer
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
     * Sets the Table's Dealer
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
     * Adds a Player to the Table
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

        // Sets the button to the first Player
        if (empty($this->players)) {
            $player->setButton(true);
        }

        // Set the Player's seat number
        $player->setSeat(count($this->players));

        $this->players[] = $player;
        $this->attach($player);

        // Creates a new betting zone for the new Player
        $this->playersBets[] = new Stack(0);

        // Notifies all TableObservers that a new Player has joined the Table
        $this->notify(new TableEvent(
            TableEvent::PLAYER_JOINS,
            $player->getName() . " has joined the table."
        ));

        return $this;
    }

    /**
     * Removes a Player from the Table
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

                // Removes the Player's betting zone
                unset($this->playersBets[$key]);

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
     * Gets the Players seated at the Table
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
     * Gets the number of seated Players
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
     * Gets the Table's CommunityCards
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
     * Sets the Table's CommunityCards
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
     * Gets the Table's Muck
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
     * Sets the Table's Muck
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

    /**
     * Sets the Table's logger
     *
     * @since  {nextRelease}
     *
     * @param  TableEventLogger $logger
     */
    public function setLogger(TableEventLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Notifies all TableObservers about changes in the TableSubject
     *
     * @since  {nextRelease}
     *
     * @param TableEvent $event The Event being fired
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function notify(TableEvent $event)
    {
        if (!is_null($this->logger)) {
            $this->logger->info($event->getMessage());
        }
        parent::notify($event);
    }

    public function setActiveHand(Hand $hand)
    {
        $this->activeHand = $hand;
        return $this;
    }

    public function getActiveHand()
    {
        return $this->activeHand;
    }

    public function getPlayersBets()
    {
        return $this->playersBets;
    }

    public function getPlayerBets(Player $player)
    {
        if ($this->getPlayerCount() == 0) {
            return null;
        }

        foreach ($this->players as $key => $value) {
            if ($value == $player) {
                return $this->playersBets[$key];
            }
        }

        return null;
    }

    /**
     * Moves each Player's bets to the main pot
     *
     * @since  {nextRelease}
     */
    public function moveToPot()
    {
        foreach ($this->playersBets as $stack) {
            $amount = $stack->getSize();
            $this->pot += $amount;
            $stack->sub($amount);
        }
    }
}
