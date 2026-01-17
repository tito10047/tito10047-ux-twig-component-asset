<?php

namespace Tito10047\UX\TwigComponentSdc;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

use Tito10047\UX\TwigComponentSdc\CompilerPass\AssetComponentCompilerPass;
use Tito10047\UX\TwigComponentSdc\DependencyInjection\Configuration;

/**
 * @link https://symfony.com/doc/current/bundles/best_practices.html
 */
class TwigComponentSdc extends AbstractBundle implements PrependExtensionInterface
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->import('../config/definition.php');
    }
    
    public function prepend(ContainerBuilder $builder): void
    {
        $configs = $builder->getExtensionConfig($this->getName());
        
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs, $builder);

        $builder->prependExtensionConfig('twig', [
            'paths' => [
                $config['ux_components_dir'] => null,
            ],
        ]);

        $builder->prependExtensionConfig('framework', [
            'asset_mapper' => [
                'paths' => [
                    $config['ux_components_dir'],
                ],
            ],
        ]);

        if (null !== $config['component_namespace']) {
            $builder->prependExtensionConfig('twig_component', [
                'defaults' => [
                    $config['component_namespace'] => $config['ux_components_dir'],
                ],
            ]);
        }

        if ($config['stimulus']['enabled'] && $builder->hasExtension('stimulus')) {
            $builder->prependExtensionConfig('stimulus', [
                'controller_paths' => [
                    $config['ux_components_dir'],
                ],
            ]);
        }
    }

    private function processConfiguration(Configuration $configuration, array $configs, ContainerBuilder $container): array
    {
        $processor = new \Symfony\Component\Config\Definition\Processor();
        return $processor->processConfiguration($configuration, $configs);
    }
    
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.php');

        $builder->getDefinition('Tito10047\UX\TwigComponentSdc\EventListener\AssetResponseListener')
            ->setArgument('$placeholder', $config['placeholder']);

        $builder->getDefinition('Tito10047\UX\TwigComponentSdc\Twig\AssetExtension')
            ->setArgument('$placeholder', $config['placeholder']);
            
        $builder->setParameter('twig_component_sdc.auto_discovery', $config['auto_discovery']);
        $builder->setParameter('twig_component_sdc.ux_components_dir', $config['ux_components_dir']);
        $builder->setParameter('twig_component_sdc.component_namespace', $config['component_namespace']);

        if (null !== $config['component_namespace']) {
            $builder->register(rtrim($config['component_namespace'], '\\'), rtrim($config['component_namespace'], '\\'))
                ->setAutoconfigured(true)
                ->setAutowired(true);
        }

        $builder->setAlias('app.ui_components.dir', 'twig_component_sdc.ux_components_dir');
        $builder->setParameter('app.ui_components.dir', $config['ux_components_dir']);
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new AssetComponentCompilerPass());
    }
}