<?php

namespace NxsSpryker\Zed\ConfigurationGui;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ConfigurationGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CONFIGURATION_GUI_PLUGINS = 'CONFIGURATION_GUI_PLUGINS';
    public const CONFIGURATION_FACADE = 'CONFIGURATION_FACADE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $this->addConfigurationGuiPlugins($container);
        $this->addConfigurationFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addConfigurationGuiPlugins(Container $container): Container
    {
        $container[self::CONFIGURATION_GUI_PLUGINS] = function () {
            return $this->getConfigurationGuiPlugins();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addConfigurationFacade(Container $container): Container
    {
        $container[self::CONFIGURATION_FACADE] = function (Container $container) {
            return $container->getLocator()->configuration()->facade();
        };

        return $container;
    }

    /**
     * @return \NxsSpryker\Zed\ConfigurationGui\Communication\Plugin\ConfigurationGuiPluginInterface[]
     */
    protected function getConfigurationGuiPlugins(): array
    {
        return [];
    }
}
