<?php

namespace Tests\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use TexasHoldemBundle\DependencyInjection\Configuration;

class ConfigurationTest extends \Tests\BaseTestCase
{
    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $treeBuilder = new TreeBuilder('php_poker_alho');

        $this->assertEquals($treeBuilder, $configuration->getConfigTreeBuilder());
    }
}
