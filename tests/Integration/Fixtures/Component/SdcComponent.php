<?php

namespace Tito10047\UX\TwigComponentSdc\Tests\Integration\Fixtures\Component;

use Tito10047\UX\TwigComponentSdc\Attribute\AsSdcComponent;

#[AsSdcComponent('SdcComponent', template: 'components/SdcComponent.html.twig', css: 'css/sdc.css', js: 'js/sdc.js')]
class SdcComponent
{
}
