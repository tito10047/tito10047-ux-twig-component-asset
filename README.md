# UX Twig Component SDC Bundle

A Symfony bundle that implements the **Single Directory Component (SDC)** methodology for Symfony UX. It bridges the gap between **AssetMapper** and **Twig Components** by providing a fully automated, convention-over-configuration workflow.

## The Concept

This bundle is inspired by the architectural challenges discussed in **["A Better Architecture for Your Symfony UX Twig Components"](https://hugo.alliau.me/blog/posts/a-better-architecture-for-your-symfony-ux-twig-components)** by **Hugo Alliaume**.

Instead of scattering your component files across `src/`, `templates/`, and `assets/`, this bundle allows you to keep everything in one place.

## Quick Example

Just create a directory for your component. Everything else is handled automatically.

```text
src_component/
└── Component/
    └── Alert/
        ├── Alert.php           # Auto-registered logic
        ├── Alert.html.twig     # Auto-mapped template
        ├── Alert.css           # Auto-injected styles
        └── alert_controller.js # Auto-mapped Stimulus controller

```

```php
namespace App\Component\Alert;

use Tito10047\UX\TwigComponentSdc\Attribute\AsSdcComponent;

#[AsSdcComponent] // No need to define names, templates, or assets. It's all inferred!
class Alert
{
    public string $type = 'info';
    public string $message;
}

```

> [!TIP]
> **Zero Configuration Magic:** The bundle automatically registers the component, maps the template based on its location, and injects the required CSS/JS into your HTML header only when the component is rendered.

---

## Key Features

* **Automatic Registration:** Every class marked with `#[AsSdcComponent]` is automatically discovered and registered.
* **Smart Template Mapping:** Forget `template: 'components/Alert.html.twig'`. If the template is in the same folder as your class, it's found automatically.
* **Asset Orchestration:** CSS and JS files in your component folder are collected during rendering and injected into the `<head>`.
* **No "Phantom" Controllers:** Load component-specific CSS via **AssetMapper** without the need for empty Stimulus controllers just for imports.
* **Performance First:** * **Compiler Pass:** All file discovery happens at build time. Zero reflection in production.
* **Response Post-processing:** Assets are injected at the end of the request.
* **HTTP Preload:** Automatic generation of `Link` headers to trigger early browser downloads.



---

## Installation & Setup

1. **Install via Composer:**
```bash
composer require tito10047/ux-twig-component-sdc

```


2. **Add the placeholder to your base template:**
   Place this in your `<head>` to define where the collected assets should be injected:
```twig
<head>
    {# ... #}
    {{ render_sdc_assets() }}
</head>

```



## How It Works

1. **Discovery:** During container compilation, the bundle scans your component directory. It maps PHP classes to their neighboring `.twig`, `.css`, and `.js` files.
2. **Rendering:** When a component is used on a page, the bundle's listener intercepts the `PreCreateForRenderEvent` and logs its required assets.
3. **Injection:** The `AssetResponseListener` replaces your Twig placeholder with the actual `<link>` and `<script>` tags and adds HTTP preload headers to the response.

## Why SDC?

1. **Maintainability:** Everything related to a UI element is in one folder.
2. **Developer Experience:** No more jumping between four different directories to change one button's color.
3. **Efficiency:** Only the CSS/JS needed for the current page is sent to the user.

## License

MIT

---

### Čo by som ti navrhol ako ďalší krok?

Teraz, keď máš jasno v názve a vízii, môžeme sa pozrieť na **Compiler Pass**. Ten bude musieť:

1. Nájsť všetky triedy v tvojom `src/Component` priečinku.
2. Pomocou `ReflectionClass::getFileName()` zistiť, kde presne súbor leží.
3. Skontrolovať existenciu `.twig`, `.css` a `.js` súborov v tom istom priečinku.
4. Dynamicky zaregistrovať služby s týmito nastaveniami do Symfony DI.

**Chceš, aby som ti pripravil logiku tohto skenovania v Compiler Passe?**