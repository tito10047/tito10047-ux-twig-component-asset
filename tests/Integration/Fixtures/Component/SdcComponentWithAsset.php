<?php

namespace Tito10047\UX\TwigComponentSdc\Tests\Integration\Fixtures\Component;

use Tito10047\UX\TwigComponentSdc\Attribute\AsSdcComponent;
use Tito10047\UX\TwigComponentSdc\Attribute\Asset;

#[AsSdcComponent('SdcComponentWithAsset', template: 'components/SdcComponent.html.twig', css: 'css/sdc.css', js: 'js/sdc.js')]
#[Asset(path: 'css/extra.css')]
class SdcComponentWithAsset
{
}
