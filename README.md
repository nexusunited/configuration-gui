# NxsSpryker/ConfigurationGui #

Module is used for configurations administration in Zed.
Module depends on NxsSpryker/Configuration module and takes defined configurable values from that module.

### Installation ###

```
composer require nxsspryker/configuration-gui
```

To ***register configuration-gui plugins*** override ConfigurationGuiDependencyProvider:

```php
<?php

namespace Pyz\Zed\Configuration;

use NxsSpryker\Zed\ConfigurationGui\ConfigurationGuiDependencyProvider as NxsSprykerConfigurationGuiDependencyProvider;
use Pyz\Zed\ConfigurationGui\Communication\Plugin\ExampleConfigurationGuiPlugin;

class ConfigurationGuiDependencyProvider extends NxsSprykerConfigurationGuiDependencyProvider
{
    /**
         * @return \NxsSpryker\Zed\ConfigurationGui\Communication\Plugin\ConfigurationGuiPluginInterface[]
         */
        protected function getConfigurationGuiPlugins(): array
        {
            return [
                /* Defined plugins that should be displayed in Zed administration goes here */
                new ExampleConfigurationGuiPlugin(),
            ];
        }
}

```

### Usage ###

To ***create configuration-gui plugin*** create a class extending NxsSpryker\Zed\ConfigurationGui\Communication\Plugin\AbstractConfigurationGuiPlugin
and register it in ConfigurationGuiDependencyProvider. Example:

```php
<?php

namespace Pyz\Zed\ConfigurationGui\Communication\Plugin;

use NxsSpryker\Zed\Configuration\Communication\Plugin\ConfigurationValueInterface;
use NxsSpryker\Zed\ConfigurationGui\Communication\Plugin\AbstractConfigurationGuiPlugin;
use Pyz\Zed\Configuration\Communication\Plugin\ExampleConfigurationValue;

class ExampleConfigurationGuiPlugin extends AbstractConfigurationGuiPlugin
{
    const FORM_LABEL = 'Form label to be displayed in Zed administration';
    const FIELD_LABEL = 'Field label';

    /**
     * @return \NxsSpryker\Zed\Configuration\Communication\Plugin\ConfigurationValueInterface
     */
    public function getConfigurationValue(): ConfigurationValueInterface
    {
        // This should return your configuration value implementing ConfigurationValueInterface
        return new ExampleConfigurationValue();
    }

    /**
     * @return string
     */
    protected function getFormLabel(): string
    {
        return self::FORM_LABEL;
    }

    /**
     * @return string
     */
    protected function getConfigurationFieldLabel(): string
    {
        return self::FIELD_LABEL;
    }
}

```
