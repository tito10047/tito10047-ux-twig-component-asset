<?php

namespace Tito10047\UX\TwigComponentSdc\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tito10047\UX\TwigComponentSdc\DependencyInjection\TwigComponentSdcExtension;

class TwigComponentSdcExtensionTest extends TestCase
{
    public function testLoadSetsParameters(): void
    {
        $container = new ContainerBuilder();
        $extension = new TwigComponentSdcExtension();

        $extension->load([['component_namespace' => 'App\\Component\\']], $container);

        $this->assertTrue($container->hasParameter('twig_component_sdc.auto_discovery'));
        $this->assertEquals('%kernel.project_dir%/src_component', $container->getParameter('twig_component_sdc.ux_components_dir'));
        $this->assertEquals('App\\Component\\', $container->getParameter('twig_component_sdc.component_namespace'));
    }

    public function testPrependAddsConfiguration(): void
    {
        $container = new ContainerBuilder();
        $extension = new TwigComponentSdcExtension();

        $container->prependExtensionConfig('twig_component_sdc', ['component_namespace' => 'App\\Component\\']);

        $extension->prepend($container);

        $twigConfigs = $container->getExtensionConfig('twig');
        $this->assertNotEmpty($twigConfigs);
        $this->assertArrayHasKey('%kernel.project_dir%/src_component', $twigConfigs[0]['paths']);

        $assetMapperConfigs = $container->getExtensionConfig('framework');
        $this->assertNotEmpty($assetMapperConfigs);
        $this->assertContains('%kernel.project_dir%/src_component', $assetMapperConfigs[0]['asset_mapper']['paths']);

        $twigComponentConfigs = $container->getExtensionConfig('twig_component');
        $this->assertNotEmpty($twigComponentConfigs);
        $this->assertEquals('%kernel.project_dir%/src_component', $twigComponentConfigs[0]['defaults']['App\\Component\\']);
    }
}
