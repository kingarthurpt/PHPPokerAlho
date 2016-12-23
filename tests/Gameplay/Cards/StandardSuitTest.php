<?php

namespace Tests;

use PHPPokerAlho\Gameplay\Cards\Suit;
use PHPPokerAlho\Gameplay\Cards\StandardSuit;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardSuitTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Gameplay\Cards\StandardSuit::fromAbbr
     *
     * @since  nextRelease
     */
    public function testFromAbbr()
    {
        $this->assertNull(StandardSuit::fromAbbr('x'));

        $this->assertInstanceOf(StandardSuit::class, StandardSuit::fromAbbr('c'));
        $this->assertInstanceOf(StandardSuit::class, StandardSuit::fromAbbr('d'));
        $this->assertInstanceOf(StandardSuit::class, StandardSuit::fromAbbr('h'));
        $this->assertInstanceOf(StandardSuit::class, StandardSuit::fromAbbr('s'));
    }
}
