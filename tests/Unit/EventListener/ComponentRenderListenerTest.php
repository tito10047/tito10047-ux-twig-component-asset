<?php

namespace Tito10047\UX\TwigComponentSdc\Tests\Unit\EventListener;

use PHPUnit\Framework\TestCase;
use Symfony\UX\TwigComponent\Event\PreCreateForRenderEvent;
use Tito10047\UX\TwigComponentSdc\Dto\ComponentAssetMap;
use Tito10047\UX\TwigComponentSdc\EventListener\ComponentRenderListener;
use Tito10047\UX\TwigComponentSdc\Service\AssetRegistry;

final class ComponentRenderListenerTest extends TestCase
{
    public function testOnPreCreateAddsAssetsToRegistry(): void
    {
        $map = new ComponentAssetMap([
            'my_component' => [
                ['path' => 'comp.css', 'type' => 'css', 'priority' => 10, 'attributes' => []]
            ]
        ]);
        $registry = new AssetRegistry();
        $listener = new ComponentRenderListener($map, $registry);

        $event = new PreCreateForRenderEvent('my_component', []);
        $listener->onPreCreate($event);

        $assets = $registry->getSortedAssets();
        $this->assertCount(1, $assets);
        $this->assertSame('comp.css', $assets[0]['path']);
    }
}
