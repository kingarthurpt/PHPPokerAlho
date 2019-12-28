<?php

namespace Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use TexasHoldemBundle\DependencyInjection\TexasHoldemExtension;

class TexasHoldemExtensionTest extends \Tests\BaseTestCase
{
    public function testLoad()
    {
        $extension = new TexasHoldemExtension();
        $configs = [];
        $params = [];
        $parameterBag = new ParameterBag($params);
        $containerBuilder = new ContainerBuilder($parameterBag);

        $this->assertNull($extension->load($configs, $containerBuilder));
    }
}
