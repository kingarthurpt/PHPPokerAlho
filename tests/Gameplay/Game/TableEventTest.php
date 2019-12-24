<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\TableEvent;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class TableEventTest extends \Tests\BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\TableEvent::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $event = new TableEvent(TableEvent::PLAYER_JOINS, 'Joined the table');
        $this->assertEquals(
            TableEvent::PLAYER_JOINS,
            $this->getPropertyValue($event, 'type')
        );
        $this->assertEquals(
            'Joined the table',
            $this->getPropertyValue($event, 'message')
        );

        return $event;
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\TableEvent::getType
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  TableEvent $event The TableEvent
     */
    public function testGetType(TableEvent $event)
    {
        $this->assertEquals(
            $this->getPropertyValue($event, 'type'),
            $event->getType()
        );
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\TableEvent::getMessage
     *
     * @depends testConstruct
     *
     * @since  nextRelease
     *
     * @param  TableEvent $event The TableEvent
     */
    public function testGetMessage(TableEvent $event)
    {
        $this->assertEquals(
            $this->getPropertyValue($event, 'message'),
            $event->getMessage()
        );
    }
}
