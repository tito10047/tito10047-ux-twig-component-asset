potrebujeme v bundli spravit takuto konfiguraciu
ux_components_dir sa bude konfigurovat cez konfig a defaultne bude '%kernel.project_dir%/src_component'

stimulus nastavenie sa nastavi len ak je stimulus nainstalovany a v konfigu sa to bude dat vypnut
namespace App\Component\ sa bude dat tiz konfigurovat, defaultne vsak bude App\Component\


```yaml
parameters:
  app.ui_components.dir: '%kernel.project_dir%/src_component'

services:
  _defaults:
    autowire: true
    autoconfigure: true

  App\Component\:
    resource: '%app.ui_components.dir%'

twig:
  paths:
    - '%app.ui_components.dir%'

framework:
  asset_mapper:
    paths:
      - '%app.ui_components.dir%'

stimulus:
  controller_paths:
    - '%app.ui_components.dir%'
    - '%kernel.project_dir%/assets/controllers'

twig_component:
  defaults:
    App\Component\: '%app.ui_components.dir%'
   ```