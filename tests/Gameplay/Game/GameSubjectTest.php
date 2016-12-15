<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Game\GameSubject;
use PHPPokerAlho\Gameplay\Game\GameObserver;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class GameSubjectTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Game\GameSubject::__construct
     *
     * @since  nextRelease
     */
    public function testConstruct()
    {
        $subject = $this->getMockForAbstractClass(GameSubject::class);
        $this->assertInstanceOf(GameSubject::class, $subject);

        $this->assertEquals(
            array(),
            $this->getPropertyValue($subject, 'observers')
        );
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\GameSubject::attach
     *
     * @since  nextRelease
     */
    public function testAttach()
    {
        $subject = $this->getMockForAbstractClass(GameSubject::class);
        $observer = $this->getMockForAbstractClass(GameObserver::class);
        $this->assertTrue($subject->attach($observer));
        $this->assertFalse($subject->attach($observer));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\GameSubject::detach
     *
     * @since  nextRelease
     */
    public function testDetach()
    {
        $subject = $this->getMockForAbstractClass(GameSubject::class);
        $observer1 = $this->getMockForAbstractClass(GameObserver::class);
        $observer2 = $this->getMockForAbstractClass(GameObserver::class);

        $this->assertTrue($subject->attach($observer1));
        $this->assertTrue($subject->detach($observer1));

        $this->assertFalse($subject->detach($observer2));
    }

    /**
     * @covers \PHPPokerAlho\Gameplay\Game\GameSubject::notify
     *
     * @since  nextRelease
     */
    public function testNotify()
    {
        $subject = $this->getMockForAbstractClass(GameSubject::class);
        $this->assertFalse($subject->notify());

        $observer = $this->getMockForAbstractClass(GameObserver::class);
        $subject->attach($observer);
        $this->assertTrue($subject->notify());
    }
}
