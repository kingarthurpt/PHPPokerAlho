<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\TableSubject;
use TexasHoldemBundle\Gameplay\Game\TableObserver;
use TexasHoldemBundle\Gameplay\Game\TableEvent;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class TableSubjectTest extends \Tests\BaseTestCase
{
    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\TableSubject::attach
     *
     * @since  nextRelease
     */
    public function testAttach()
    {
        $subject = $this->getMockForAbstractClass(TableSubject::class);
        $observer = $this->getMockForAbstractClass(TableObserver::class);
        $this->assertTrue($subject->attach($observer));
        $this->assertFalse($subject->attach($observer));
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\TableSubject::detach
     *
     * @since  nextRelease
     */
    public function testDetach()
    {
        $subject = $this->getMockForAbstractClass(TableSubject::class);
        $observer1 = $this->getMockForAbstractClass(TableObserver::class);
        $observer2 = $this->getMockForAbstractClass(TableObserver::class);

        $this->assertTrue($subject->attach($observer1));
        $this->assertTrue($subject->detach($observer1));

        $this->assertFalse($subject->detach($observer2));
    }

    /**
     * @covers \TexasHoldemBundle\Gameplay\Game\TableSubject::notify
     *
     * @since  nextRelease
     */
    public function testNotify()
    {
        $subject = $this->getMockForAbstractClass(TableSubject::class);
        $event = new TableEvent(1, "message");
        $this->assertFalse($subject->notify($event));

        $observer = $this->getMockForAbstractClass(TableObserver::class);
        $subject->attach($observer);
        $this->assertTrue($subject->notify($event));
    }
}
