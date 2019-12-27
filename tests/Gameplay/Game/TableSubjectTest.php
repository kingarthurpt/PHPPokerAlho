<?php

namespace Tests\Gameplay\Game;

use TexasHoldemBundle\Gameplay\Game\TableEvent;
use TexasHoldemBundle\Gameplay\Game\TableEventLogger;
use TexasHoldemBundle\Gameplay\Game\TableObserver;
use TexasHoldemBundle\Gameplay\Game\TableSubject;

class TableSubjectTest extends \Tests\BaseTestCase
{
    public function testAttach()
    {
        $subject = $this->getMockForAbstractClass(TableSubject::class);
        $observer = $this->getMockForAbstractClass(TableObserver::class);
        $this->assertTrue($subject->attach($observer));
        $this->assertFalse($subject->attach($observer));
    }

    public function testDetach()
    {
        $subject = $this->getMockForAbstractClass(TableSubject::class);
        $observer1 = $this->getMockForAbstractClass(TableObserver::class);
        $observer2 = $this->getMockForAbstractClass(TableObserver::class);

        $this->assertTrue($subject->attach($observer1));
        $this->assertTrue($subject->detach($observer1));

        $this->assertFalse($subject->detach($observer2));
    }

    public function testNotify()
    {
        $logger = new \Symfony\Component\HttpKernel\Log\Logger;
        $tableEventLogger = new TableEventLogger($logger);
        $subject = $this->getMockForAbstractClass(TableSubject::class);
        $subject->setLogger($tableEventLogger);

        $event = new TableEvent(1, 'message');
        $this->assertFalse($subject->notify($event));

        $observer = $this->getMockForAbstractClass(TableObserver::class);
        $subject->attach($observer);
        $this->assertTrue($subject->notify($event));


    }
}
