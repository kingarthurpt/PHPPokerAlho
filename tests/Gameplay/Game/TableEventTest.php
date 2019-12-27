<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\TableEvent;

class TableEventTest extends \Tests\BaseTestCase
{
    private $event;

    protected function setUp(): void
    {
        $this->event = new TableEvent(TableEvent::PLAYER_JOINS, 'Joined the table');
    }

    public function testConstruct()
    {
        $this->assertEquals(
            TableEvent::PLAYER_JOINS,
            $this->getPropertyValue($this->event, 'type')
        );
        $this->assertEquals(
            'Joined the table',
            $this->getPropertyValue($this->event, 'message')
        );
    }

    public function testGetType()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->event, 'type'),
            $this->event->getType()
        );
    }

    public function testGetMessage()
    {
        $this->assertEquals(
            $this->getPropertyValue($this->event, 'message'),
            $this->event->getMessage()
        );
    }
}
