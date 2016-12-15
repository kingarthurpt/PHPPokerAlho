<?php

namespace Tests;

use PHPPokerAlho\Cards\StandardSuitFactory;

/**
 * @since  {nextRelease}
 *
 * @author Artur Alves <artur.ze.alves@gmail.com>
 */
class StandardSuitFactoryTest extends BaseTestCase
{
    /**
     * @covers \PHPPokerAlho\Cards\StandardSuitFactory::create
     *
     * @since  nextRelease
     */
    public function testCreate()
    {
        $factory = new StandardSuitFactory();
        $suit = $factory->create(StandardSuitFactory::STD_CLUBS);
        $this->assertEquals(
            StandardSuitFactory::STD_CLUBS[0],
            $suit->getName()
        );
        $this->assertEquals(
            StandardSuitFactory::STD_CLUBS[1],
            $suit->getSymbol()
        );
    }
}
